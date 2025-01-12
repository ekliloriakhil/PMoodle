<?php // $Id$
/**
 * Info about the local environment, wrt RPC
 *
 * This should really be a singleton. A PHP5 Todo I guess.
 */

class mnet_environment {

    var $id                 = 0;
    var $wwwroot            = '';
    var $ip_address         = '';
    var $public_key         = '';
    var $public_key_expires = 0;
    var $last_connect_time  = 0;
    var $last_log_id        = 0;
    var $keypair            = array();
    var $deleted            = 0;

    function mnet_environment() {
        return true;
    }

    function init() {
        global $CFG;

        if (empty($CFG->mnet_dispatcher_mode)) {
            set_config('mnet_dispatcher_mode', 'off');
        }

        // Bootstrap the object data on first load.
        if (empty($CFG->mnet_localhost_id) ) {
            if (!$CFG->mnet_localhost_id = get_config(NULL, 'mnet_localhost_id')) {  // Double-check db
                $this->wwwroot    = $CFG->wwwroot;
                if (empty($_SERVER['SERVER_ADDR'])) {
                    // SERVER_ADDR is only returned by Apache-like webservers
                    $my_hostname = mnet_get_hostname_from_uri($CFG->wwwroot);
                    $my_ip       = gethostbyname($my_hostname);  // Returns unmodified hostname on failure. DOH!
                    if ($my_ip == $my_hostname) {
                        $this->ip_address = 'UNKNOWN';
                    } else {
                        $this->ip_address = $my_ip;
                    }
                } else {
                    $this->ip_address = $_SERVER['SERVER_ADDR'];
                }

                if ($existingrecord = get_record('mnet_host', 'ip_address', $this->ip_address)) {
                    $this->id = $existingrecord->id;
                } else {  // make a new one
                    $this->id       = insert_record('mnet_host', $this, true);
                }
    
                set_config('mnet_localhost_id', $this->id);
                $this->get_keypair();
            }
        } else {
            $hostobject = get_record('mnet_host','id', $CFG->mnet_localhost_id);
            if(is_object($hostobject)) {
                $temparr = get_object_vars($hostobject);
                foreach($temparr as $key => $value) {
                    $this->$key = $value;
                }
                unset($hostobject, $temparr);
            } else {
                return false;
            }

            // Unless this is an install/upgrade, generate the SSL keys.
            if(empty($this->public_key)) {
                $this->get_keypair();
            }
        }

        // We need to set up a record that represents 'all hosts'. Any rights
        // granted to this host will be conferred on all hosts.
        if (empty($CFG->mnet_all_hosts_id) ) {
            $hostobject                     = new stdClass();
            $hostobject->wwwroot            = '';
            $hostobject->ip_address         = '';
            $hostobject->public_key         = '';
            $hostobject->public_key_expires = '';
            $hostobject->last_connect_time  = '0';
            $hostobject->last_log_id        = '0';
            $hostobject->deleted            = 0;
            $hostobject->name               = 'All Hosts';

            $hostobject->id = insert_record('mnet_host',$hostobject, true);
            set_config('mnet_all_hosts_id', $hostobject->id);
            $CFG->mnet_all_hosts_id = $hostobject->id;
            unset($hostobject);
        }
    }

    function get_keypair() {
        // We don't generate keys on install/upgrade because we want the USER
        // record to have an email address, city and country already.
        if (!empty($_SESSION['upgraderunning'])) return true;
        if (!extension_loaded("openssl")) return true;
        if (!empty($this->keypair)) return true;

        $this->keypair = array();
        $keypair = get_field('config_plugins', 'value', 'plugin', 'mnet', 'name', 'openssl');

        if (!empty($keypair)) {
            // Explode/Implode is faster than Unserialize/Serialize
            list($this->keypair['certificate'], $this->keypair['keypair_PEM']) = explode('@@@@@@@@', $keypair);
        }

        if ($this->public_key_expires > time()) {
            $this->keypair['privatekey'] = openssl_pkey_get_private($this->keypair['keypair_PEM']);
            $this->keypair['publickey']  = openssl_pkey_get_public($this->keypair['certificate']);
        } else {
            // Key generation/rotation

            // 1. Archive the current key (if there is one).
            $result = get_field('config_plugins', 'value', 'plugin', 'mnet', 'name', 'openssl_history');
            if(empty($result)) {
                set_config('openssl_history', serialize(array()), 'mnet');
                $openssl_history = array();
            } else {
                $openssl_history = unserialize($result);
            }

            if(count($this->keypair)) {
                $this->keypair['expires'] = $this->public_key_expires;
                array_unshift($openssl_history, $this->keypair);
            }

            // 2. How many old keys do we want to keep? Use array_slice to get 
            // rid of any we don't want
            $openssl_generations = get_field('config_plugins', 'value', 'plugin', 'mnet', 'name', 'openssl_generations');
            if(empty($openssl_generations)) {
                set_config('openssl_generations', 3, 'mnet');
                $openssl_generations = 3;
            }

            if(count($openssl_history) > $openssl_generations) {
                $openssl_history = array_slice($openssl_history, 0, $openssl_generations);
            }

            set_config('openssl_history', serialize($openssl_history), 'mnet');

            // 3. Generate fresh keys
            $this->replace_keys();
        }
        return true;
    }

    function replace_keys() {
        $this->keypair = array();
        $this->keypair = mnet_generate_keypair();
        $this->public_key         = $this->keypair['certificate'];
        $details                  = openssl_x509_parse($this->public_key);
        $this->public_key_expires = $details['validTo_time_t'];

        set_config('openssl', implode('@@@@@@@@', $this->keypair), 'mnet');

        update_record('mnet_host', $this);
        error_log('New public key has been generated. It expires ' . date('Y/m/d h:i:s', $this->public_key_expires));
    }

    function get_private_key() {
        if (empty($this->keypair)) $this->get_keypair();
        if (isset($this->keypair['privatekey'])) return $this->keypair['privatekey'];
        $this->keypair['privatekey'] = openssl_pkey_get_private($this->keypair['keypair_PEM']);
        return $this->keypair['privatekey'];
    }

    function get_public_key() {
        if (!isset($this->keypair)) $this->get_keypair();
        if (isset($this->keypair['publickey'])) return $this->keypair['publickey'];
        $this->keypair['publickey'] = openssl_pkey_get_public($this->keypair['certificate']);
        return $this->keypair['publickey'];
    }
}

?>
