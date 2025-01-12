<?php
/**
 * @author Martin Dougiamas
 * @author Lukas Haemmerle
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @package moodle multiauth
 *
 * Authentication Plugin: Shibboleth Authentication
 *
 * Authentication using Shibboleth.
 *
 * Distributed under GPL (c)Markus Hagman 2004-2006
 *
 * 10.2004     SHIBBOLETH Authentication functions v.0.1
 * 05.2005     Various extensions and fixes by Lukas Haemmerle
 * 10.2005     Added better error messags
 * 05.2006     Added better handling of mutli-valued attributes
 * 2006-08-28  File created, code imported from lib.php
 * 2006-10-27  Upstream 1.7 changes merged in, added above credits from lib.php :-)
 * 2007-03-09  Fixed authentication but may need some other changes
 * 2007-10-03  Removed requirement for email address, surname and given name on request of Markus Hagman
  * 2008-01-21 Added WAYF functionality

 */

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}

require_once($CFG->libdir.'/authlib.php');

/**
 * Shibboleth authentication plugin.
 */
class auth_plugin_shibboleth extends auth_plugin_base {

    /**
     * Constructor.
     */
    function auth_plugin_shibboleth() {
        $this->authtype = 'shibboleth';
        $this->config = get_config('auth/shibboleth');
    }

    /**
     * Returns true if the username and password work and false if they are
     * wrong or don't exist.
     *
     * @param string $username The username (with system magic quotes)
     * @param string $password The password (with system magic quotes)
     * @return bool Authentication success or failure.
     */
    function user_login($username, $password) {
        
        // If we are in the shibboleth directory then we trust the server var
        if (!empty($_SERVER[$this->config->user_attribute])) {
            return (strtolower($_SERVER[$this->config->user_attribute]) == strtolower($username));
        } else {
            // If we are not, the user has used the manual login and the login name is
            // unknown, so we return false.
            return false;
        }
    }


    
    /**
     * Returns the user information for 'external' users. In this case the
     * attributes provided by Shibboleth
     *
     * @return array $result Associative array of user data
     */
    function get_userinfo($username) {
    // reads user information from shibboleth attributes and return it in array()
        global $CFG;

        // Check whether we have got all the essential attributes
        if ( empty($_SERVER[$this->config->user_attribute]) ) {
            print_error( 'shib_not_all_attributes_error', 'auth' , '', "'".$this->config->user_attribute."' ('".$_SERVER[$this->config->user_attribute]."'), '".$this->config->field_map_firstname."' ('".$_SERVER[$this->config->field_map_firstname]."'), '".$this->config->field_map_lastname."' ('".$_SERVER[$this->config->field_map_lastname]."') and '".$this->config->field_map_email."' ('".$_SERVER[$this->config->field_map_email]."')");
        }

        $attrmap = $this->get_attributes();

        $result = array();
        $search_attribs = array();

        foreach ($attrmap as $key=>$value) {
            // Check if attribute is present  
            if (!isset($_SERVER[$value])){
                $result[$key] = '';
                continue;
            }

            // Make usename lowercase
            if ($key == 'username'){
                $result[$key] = strtolower($this->get_first_string($_SERVER[$value]));
            } else {
                $result[$key] = $this->get_first_string($_SERVER[$value]);
            }
        }

         // Provide an API to modify the information to fit the Moodle internal
        // data representation
        if (
              $this->config->convert_data
              && $this->config->convert_data != ''
              && is_readable($this->config->convert_data)
            ) {

            // Include a custom file outside the Moodle dir to
            // modify the variable $moodleattributes
            include($this->config->convert_data);
        }

        return $result;
    }

    /**
     * Returns array containg attribute mappings between Moodle and Shibboleth.
     *
     * @return array
     */
    function get_attributes() {
        $configarray = (array) $this->config;

        $moodleattributes = array();
        foreach ($this->userfields as $field) {
            if (isset($configarray["field_map_$field"])) {
                $moodleattributes[$field] = $configarray["field_map_$field"];
            }
        }
        $moodleattributes['username'] = $configarray["user_attribute"];

        return $moodleattributes;
    }

    /**
     * Returns true if this authentication plugin is 'internal'.
     *
     * @return bool
     */
    function is_internal() {
        return false;
    }

    /**
     * Returns true if this authentication plugin can change the user's
     * password.
     *
     * @return bool
     */
    function can_change_password() {
        return false;
    }

     /**
     * Hook for login page
     *
     */
    function loginpage_hook() {
        global $SESSION, $CFG;

        // Prevent username from being shown on login page after logout
        $CFG->nolastloggedin = true;

        return;
    }

    /**
     * Prints a form for configuring this authentication plugin.
     *
     * This function is called from admin/auth.php, and outputs a full page with
     * a form for configuring this plugin.
     *
     * @param array $page An object containing all the data for this page.
     */
    function config_form($config, $err, $user_fields) {
        include "config.html";
    }

    /**
     * Processes and stores configuration data for this authentication plugin.
     *
     *
     * @param object $config Configuration object
     */
    function process_config($config) {
        global $CFG;

        // set to defaults if undefined
        if (!isset($config->auth_instructions) or empty($config->user_attribute)) {
            $config->auth_instructions = get_string('shibboleth_instructions', 'auth', $CFG->wwwroot.'/auth/shibboleth/index.php');
        }
        if (!isset ($config->user_attribute)) {
            $config->user_attribute = '';
        }
        if (!isset ($config->convert_data)) {
            $config->convert_data = '';
        }
        
        if (!isset($config->changepasswordurl)) {
            $config->changepasswordurl = '';
        }
        
        if (!isset($config->login_name)) {
            $config->login_name = 'Shibboleth Login';
        }
        
        // Clean idp list
        if (isset($config->organization_selection) && !empty($config->organization_selection) && isset($config->alt_login) && $config->alt_login == 'on') {
            $idp_list = get_idp_list($config->organization_selection);
            if (count($idp_list) < 1){
                return false;
            }
            $config->organization_selection = '';
            foreach ($idp_list as $idp => $value){
                $config->organization_selection .= $idp.', '.$value[0].', '.$value[1]."\n";
            }
        }
        

        // save settings
        set_config('user_attribute',    $config->user_attribute,    'auth/shibboleth');
        
        if (isset($config->organization_selection) && !empty($config->organization_selection)) {
            set_config('organization_selection',    $config->organization_selection,    'auth/shibboleth');
        }
        set_config('login_name',    $config->login_name,    'auth/shibboleth');
        set_config('convert_data',      $config->convert_data,      'auth/shibboleth');
        set_config('auth_instructions', $config->auth_instructions, 'auth/shibboleth');
        set_config('changepasswordurl', $config->changepasswordurl, 'auth/shibboleth');
        
        if (isset($config->alt_login) && $config->alt_login == 'on'){
            set_config('alt_login',    $config->alt_login,    'auth/shibboleth');
            set_config('alternateloginurl', $CFG->wwwroot.'/auth/shibboleth/login.php');
        } else {
            set_config('alt_login',    'off',    'auth/shibboleth');
            set_config('alternateloginurl', '');
            $config->alt_login = 'off';
        }
        
        // Check values and return false if something is wrong
        // Patch Anyware Technologies (14/05/07)
        if (($config->convert_data != '')&&(!file_exists($config->convert_data) || !is_readable($config->convert_data))){
            return false;
        }
        
        // Check if there is at least one entry in the IdP list
        if (isset($config->organization_selection) && empty($config->organization_selection) && isset($config->alt_login) && $config->alt_login == 'on'){
            return false;
        }

        return true;
    }

    /**
     * Cleans and returns first of potential many values (multi-valued attributes)
     *
     * @param string $string Possibly multi-valued attribute from Shibboleth
     */
    function get_first_string($string) {
        $list = split( ';', $string);
        $clean_string = rtrim($list[0]);

        return $clean_string;
    }
}

    
    /**
     * Sets the standard SAML domain cookie that is also used to preselect
     * the right entry on the local wayf
     *
     * @param IdP identifiere
     */
    function set_saml_cookie($selectedIDP) {
        if (isset($_COOKIE['_saml_idp']))
        {
            $IDPArray = generate_cookie_array($_COOKIE['_saml_idp']);
        }
        else
        {
            $IDPArray = array();
        }
        $IDPArray = appendCookieValue($selectedIDP, $IDPArray);
        setcookie ('_saml_idp', generate_cookie_value($IDPArray), time() + (100*24*3600));
    }
    
     /**
     * Prints the option elements for the select element of the drop down list 
     *
     */
    function print_idp_list(){
        $config = get_config('auth/shibboleth');
        
        $IdPs = get_idp_list($config->organization_selection);
        if (isset($_COOKIE['_saml_idp'])){
            $idp_cookie = generate_cookie_array($_COOKIE['_saml_idp']);
            do {
                $selectedIdP = array_pop($idp_cookie);
            } while (!isset($IdPs[$selectedIdP]) && count($idp_cookie) > 0);
            
        } else {
            $selectedIdP = '-';
        }
        
        foreach($IdPs as $IdP => $data){
            if ($IdP == $selectedIdP){
                echo '<option value="'.$IdP.'" selected="selected">'.$data[0].'</option>';
            } else {
                echo '<option value="'.$IdP.'">'.$data[0].'</option>';
            }
        }
    }
    
    
     /**
     * Generate array of IdPs from Moodle Shibboleth settings
     *
     * @param string Text containing tuble/triple of IdP entityId, name and (optionally) session initiator
     * @return array Identifier of IdPs and their name/session initiator 
     */

    function get_idp_list($organization_selection) {
        $idp_list = array();
        
        $idp_raw_list = split("\n",  $organization_selection);
        
        foreach ($idp_raw_list as $idp_line){
            $idp_data = split(',', $idp_line);
            if (isset($idp_data[2]))
            {
                $idp_list[trim($idp_data[0])] = array(trim($idp_data[1]),trim($idp_data[2])); 
            }
            elseif(isset($idp_data[1]))
            {
                $idp_list[trim($idp_data[0])] = array(trim($idp_data[1]));
            }
        }
        
        return $idp_list;
    }
    
    /**
     * Generates an array of IDPs using the cookie value
     *
     * @param string Value of SAML domain cookie 
     * @return array Identifiers of IdPs 
     */
    function generate_cookie_array($value) {
        
        // Decodes and splits cookie value
        $CookieArray = split(' ', $value);
        $CookieArray = array_map('base64_decode', $CookieArray);
        
        return $CookieArray;
    }
    
    /**
     * Generate the value that is stored in the cookie using the list of IDPs
     *
     * @param array IdP identifiers 
     * @return string SAML domain cookie value
     */
    function generate_cookie_value($CookieArray) {
    
        // Merges cookie content and encodes it
        $CookieArray = array_map('base64_encode', $CookieArray);
        $value = implode(' ', $CookieArray);
        return $value;
    }
    
    /**
     * Append a value to the array of IDPs
     *
     * @param string IdP identifier
     * @param array IdP identifiers
     * @return array IdP identifiers with appended IdP 
     */
    function appendCookieValue($value, $CookieArray) {
        
        array_push($CookieArray, $value);
        $CookieArray = array_reverse($CookieArray);
        $CookieArray = array_unique($CookieArray);
        $CookieArray = array_reverse($CookieArray);
        
        return $CookieArray;
    }


?>
