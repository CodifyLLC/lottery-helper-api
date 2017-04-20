<?php


//*****************************************************************************
//*****************************************************************************
/**
 * All Apps Plugin
 *
 * @package		RepHub
 * @subpackage	Plugins
 **/
//*****************************************************************************
//*****************************************************************************

//====================================================================
//====================================================================
// Display Error Function
//====================================================================
//====================================================================
function display_error($scope, $error_msg, $error_type=E_USER_NOTICE)
{
    $tmp_msg = "Error :: {$scope}() - {$error_msg}";
    return trigger_error($tmp_msg, $error_type);
}

//====================================================================
//====================================================================
// Referential Integrity Check Function
//====================================================================
//====================================================================
function ri_check($data_source, $table, $field, $value=false, $type='i')
{
    if ($value === false) {
        $value = $field;
        $field = 'id';
    }
    $strsql = "select count(*) as count from {$table} where {$field} = ?";
    $params = array($type, $value);
    return qdb_lookup($data_source, $strsql, 'count', $params);
}

//====================================================================
//====================================================================
// Message Functions
//====================================================================
//====================================================================
function add_bottom_message($msg) { $_SESSION['bottom_message'][] = $msg; }
function add_page_message($msg) { $_SESSION['page_message'][] = $msg; }
function add_action_message($msg) { $_SESSION['action_message'][] = $msg; }
function add_warn_message($msg) { $_SESSION['warn_message'][] = $msg; }
function add_error_message($msg) { $_SESSION['error_message'][] = $msg; }
function add_gen_message($msg) { $_SESSION['gen_message'][] = $msg; }



//*****************************************************************************
/**
 * Checks to see of a string contains a particular substring.
 *
 * @param $substring the substring to match
 * @param $string the string to search
 * @return true if $substring is found in $string, false otherwise
 */
//*****************************************************************************
function contains($needle, $haystack)
{
    if (empty($needle)) { return false; }
    $pos = stripos($haystack, $needle);
    if($pos === false) { return false; }
    else { return true; }
}

//*****************************************************************************
/**
 * @param string The table to check
 * @param string The field in which is an enum data type
 * @param string $data_source The data source to use
 * @return mixed array of default vals
 */
//*****************************************************************************
function enum_select($table, $field, $data_source='')
{
    $sql = " SHOW COLUMNS FROM `$table` LIKE '$field' ";
    $res = qdb_list($data_source, $sql);
    $enum_vals = $res[0]['Type'];
    $enum_vals = str_replace('enum(', '', $enum_vals);
    $enum_vals = str_replace(')', '', $enum_vals);
    $enum_vals = str_replace('\'', '', $enum_vals);
    $enum_vals = explode(',', $enum_vals);

    $return = array();
    foreach($enum_vals as $val) { $return[$val] = $val; }
    return $return;
}


//*****************************************************************************
/*
* This method will return the column names as an array for the given table
*
* @param string $table The table name to get columns for
*
* @return array Returns an array of column names
*/
//*****************************************************************************
function tableColumNames($table)
{
    $sql = "DESCRIBE $table ";
    $res = qdb_list('', $sql);

    $fields_array = array();
    foreach($res as $key => $field)
    {
        $fields_array[$field['Field']] = $field['Default'];
    }

    return $fields_array;
}


//*****************************************************************************
/**
 * This method will build the bind params array to make a dynamic param list
 *
 * @param array $params
 * @param string $type. Most likely either i or s
 * @param mixed $values Either an array or string of values
 */
//*****************************************************************************
function make_mysql_bind_parameters(&$params, $type, &$values)
{
    if (!is_array($params)) { $params = array(); }

    $ret_val = false;
    if (!is_array($values))
    {
        if (isset($params[0])) { $params[0] .= (string)$type; }
        else { $params[0] = (string)$type; }
        $params[] = &$values;
        $ret_val = '?';
    }
    else
    {
        if (!isset($params[0])) { $params[0] = ''; }
        foreach ($values as &$val) {
            $params[0] .= (string)$type;
            $params[] = &$val;
            if ($ret_val) { $ret_val .= ', '; }
            $ret_val .= '?';
        }
    }
    return $ret_val;
}



//*****************************************************************************
/**
 * This method will redirect the user to the given page and also send a
 * base64_encode() message with it if wanted
 *
 * @param string $location The location to send the user, if empty $_SERVER['REDIRECT_URL'] is used
 * @param string $message. The message to display once redirected
 * @param mixed $message_type The message type (this is the class for the alert-*. Options are:
 * 		'error_message', 'warn_message', 'action_message' (default), 'gen_message', 'page_message'
 */
//*****************************************************************************
function redirect($location='', $message='', $message_type='action_message')
{
    // Set the location
    $location = (empty($location)) ? ($_SERVER['REDIRECT_URL']) : ($location);

    if (!empty($message))
    {
        $x = (contains('?', $location)) ? ('&') : ('?');

        header('Location: ' . $location . $x . 'b' . $message_type . '=' . base64_encode($message));
    }
    else {
        // Redirect
        header('Location: ' . $location);
    }
}


//*****************************************************************************
/**
 * This function will return a nice formatted status indicator
 *
 * @param string $text The text to set
 * @param $type The type. Options: '', 'success', 'warning', 'important'
 */
//*****************************************************************************
function status_indicator($text, $type='')
{
    return span($text, array('class'=>'label label-' . $type));
}




/**
 * This function is used for printing debugging information
 *
 * @param string special variables to be printed along with debug information
 * @param bool set to true if you want to show the backtrace
 *
 * @return string This will return the FILE path and the LINE #
 */
function app_debug($special_vars='', $show_backtrace=false)
{
    $special_vars = (!empty($special_vars)) ? (gen_content('p', 'Var(s): ' . $special_vars)) : ('');

    $trace_back_data = debug_backtrace();
    ob_start();
    print_array($trace_back_data);
    $traceback_array = ob_get_clean();

    if (!empty($trace_back_data)) {

        ob_start();
        print gen_content('div', $trace_back_data[0]['file'] . ' on line #' . $trace_back_data[0]['line'] . $special_vars, array('style'=>'background-color: #eeeeee; border: 1px solid #dddddd; padding: 5px; margin: 55px auto 5px auto; position: relative; z-index: 1000;'));
        $debug_data = ob_get_clean();

        print $debug_data;
    }

}

/**
 * This method will check if the given email address is valid
 *
 * @param string $email The email address to check
 *
 * @return bool Returns true if it's valid, otherwise returns false
 */
function is_valid_email($email)
{
    if (contains('@', $email))
    {
        $email_parts = explode('@', $email);

        if (checkdnsrr($email_parts[1], "MX")) {
            return true;
        }
        else {
            return false;
        }
    }
    else
    {
        return false;
    }
}





/*
*   calc_time_difference
*
*   param $class css class name passed in to format the message
*
*   returns HTML message based on param
*/
function calc_time_difference($date, $force_seconds=false)
{
    // Calculate when last status update happened
    $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths = array("60","60","24","7","4.35","12","10");
    $now = time();

    $unix_date = strtotime($date);

    $difference = ($now > $unix_date) ? ($now - $unix_date) : ($unix_date - $now);

    if ($force_seconds) { return $difference; }

    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++)
    {
        $difference /= $lengths[$j];
    }

    $difference = round($difference);

    if ($difference <= 10 && $periods[$j] == 'second') { return 'a moment ago'; }

    if($difference != 1) { $periods[$j] .= "s"; }

    return $difference . ' ' . $periods[$j] . ' ago';
}

/*
*   calc_time_difference
*
*   param $class css class name passed in to format the message
*
*   returns HTML message based on param
*/
function table_exits($table_name, $db_source='')
{
    if (empty($db_source)) {
        $db_source = $_SESSION['default_data_source'];
    }
    $databaseName = $_SESSION[$db_source]['source'];
    $sql = '
		SELECT table_name
		FROM information_schema.tables
		WHERE table_schema = ?
		AND table_name = ?
	';

    $params = array('ss', $databaseName, $table_name);
    $res = qdb_exec($db_source, $sql, $params);

    return (!empty($res)) ? (true) : (false);
}

/********************************************************************************************/
/**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param string $s Size in pixels, defaults to 80px [ 1 - 512 ]
 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @param boole $img True to return a complete IMG tag False for just the URL
 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
 * @return String containing either just a URL or a complete image tag
 * @source http://gravatar.com/site/implement/images/php/
 */
/********************************************************************************************/
function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'pg', $img = false, $atts = array() ) {
    $url = 'http://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&amp;d=$d&amp;r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

/********************************************************************************************/
/**
 * bootstrap btn group
 *
 * @param string $label The text to show next to the dropdown menu
 * @param array $links. Formated like the following example:
array(
array('href'=>'/test/link', 'name'=>'Test Link'),
array('href'=>'/test/link2', 'name'=>'Test Link2', 'attrs'=>array('class'=>'test'))
);
 * @param string $btn_type Options: 'btn-primary', 'btn-warning', 'btn-error', 'btn-info', 'btn-success', 'btn-inverse'
 *
 * @return string $returns the html string for a button group
 */
/********************************************************************************************/
function bootstrap_btn_group($label, $links, $btn_type='', $carret_location='right')
{
    $btn_label = button($label, array('class'=>'btn ' . $btn_type));
    $btn_toggle = button(span('', array('class'=>'caret')), array('class'=>'btn dropdown-toggle ' . $btn_type, 'data-toggle'=>'dropdown'));

    $li = '';
    foreach($links as $key => $link) {
        $attrs = (!empty($link['attrs'])) ? ($link['attrs']) : (array());
        $li .= li(anchor($link['href'], $link['name'], $attrs));
    }
    $button_links = ul($li, array('class'=>'dropdown-menu'));

    switch($carret_location) {
        case 'right':
            return div($btn_label . $btn_toggle . $button_links, array('class'=>'btn-group'));
            break;

        case 'left':
            return div($btn_toggle . $btn_label . $button_links, array('class'=>'btn-group'));
            break;
    }

}



/********************************************************************************************/
/**
 * bootstrap date element picker
 *
 * @param string $name
 * @return string $value
 * @return string $format Default 'yyyy-mm-dd'
 */
/********************************************************************************************/
function bootstrap_date_element($name, $value, $format='yyyy-mm-dd', $span=12)
{
    ob_start();
    ?>
    <div data-date-format="<?php print $format; ?>" data-date="<?php print $value; ?>" id="dp<?php print $name; ?>" class="input-append date">
        <input type="text" name="<?php print $name; ?>" readonly="" value="<?php print $value; ?>" size="16" class="<?php print $span; ?>">
        <span class="add-on"><i class="icon-calendar"></i></span>
    </div>
    <?php
    $x = ob_get_clean();

    return $x;
}


/********************************************************************************************/
/**
 * bootstrap model
 *
 * @param string $model_header The text of the header
 * @return string $model_body the main HTML of the model
 * @return string $model_id The Id of the model, can be anything but must be unique
 */
/********************************************************************************************/
function bootstrap_model($model_header, $model_body, $model_id, $show_save=true, $show_close=true)
{
    ob_start();
    ?>
    <!-- Modal -->
    <div id="<?php print $model_id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="<?php print $model_id; ?>Label" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="<?php print $model_id; ?>Label"><?php print $model_header; ?></h3>
        </div>

        <div class="modal-body">
            <?php print $model_body; ?>
        </div>
        <div class="modal-footer">

            <?php if ($show_close) { ?>
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            <?php } ?>

            <?php if ($show_save) { ?>
                <button class="btn btn-primary btn-save">Save changes</button>
            <?php } ?>
        </div>
    </div>
    <?php
    $modal = ob_get_clean();
    return $modal;
}

function recursive_array_search($needle,$haystack) {
    foreach($haystack as $key=>$value) {
        $current_key=$key;
        if($needle===$value OR (is_array($value) && recursive_array_search($needle,$value) !== false)) {
            return $current_key;
        }
    }
    return false;
}

//
// remove_remarks will strip the sql comment lines out of an uploaded sql file
//
function remove_remarks($sql)
{
    $lines = explode("\n", $sql);

    // try to keep mem. use down
    $sql = "";

    $linecount = count($lines);
    $output = "";

    for ($i = 0; $i < $linecount; $i++)
    {
        if (($i != ($linecount - 1)) || (strlen($lines[$i]) > 0))
        {
            if (isset($lines[$i][0]) && $lines[$i][0] != "#")
            {
                $output .= $lines[$i] . "\n";
            }
            else
            {
                $output .= "\n";
            }
            // Trading a bit of speed for lower mem. use here.
            $lines[$i] = "";
        }
    }

    return $output;

}

//
// split_sql_file will split an uploaded sql file into single sql statements.
// Note: expects trim() to have already been run on $sql.
//
function split_sql_file($sql, $delimiter)
{
    // Split up our string into "possible" SQL statements.
    $tokens = explode($delimiter, $sql);

    // try to save mem.
    $sql = "";
    $output = array();

    // we don't actually care about the matches preg gives us.
    $matches = array();

    // this is faster than calling count($oktens) every time thru the loop.
    $token_count = count($tokens);
    for ($i = 0; $i < $token_count; $i++)
    {
        // Don't wanna add an empty string as the last thing in the array.
        if (($i != ($token_count - 1)) || (strlen($tokens[$i] > 0)))
        {
            // This is the total number of single quotes in the token.
            $total_quotes = preg_match_all("/'/", $tokens[$i], $matches);
            // Counts single quotes that are preceded by an odd number of backslashes,
            // which means they're escaped quotes.
            $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$i], $matches);

            $unescaped_quotes = $total_quotes - $escaped_quotes;

            // If the number of unescaped quotes is even, then the delimiter did NOT occur inside a string literal.
            if (($unescaped_quotes % 2) == 0)
            {
                // It's a complete sql statement.
                $output[] = $tokens[$i];
                // save memory.
                $tokens[$i] = "";
            }
            else
            {
                // incomplete sql statement. keep adding tokens until we have a complete one.
                // $temp will hold what we have so far.
                $temp = $tokens[$i] . $delimiter;
                // save memory..
                $tokens[$i] = "";

                // Do we have a complete statement yet?
                $complete_stmt = false;

                for ($j = $i + 1; (!$complete_stmt && ($j < $token_count)); $j++)
                {
                    // This is the total number of single quotes in the token.
                    $total_quotes = preg_match_all("/'/", $tokens[$j], $matches);
                    // Counts single quotes that are preceded by an odd number of backslashes,
                    // which means they're escaped quotes.
                    $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$j], $matches);

                    $unescaped_quotes = $total_quotes - $escaped_quotes;

                    if (($unescaped_quotes % 2) == 1)
                    {
                        // odd number of unescaped quotes. In combination with the previous incomplete
                        // statement(s), we now have a complete statement. (2 odds always make an even)
                        $output[] = $temp . $tokens[$j];

                        // save memory.
                        $tokens[$j] = "";
                        $temp = "";

                        // exit the loop.
                        $complete_stmt = true;
                        // make sure the outer loop continues at the right point.
                        $i = $j;
                    }
                    else
                    {
                        // even number of unescaped quotes. We still don't have a complete statement.
                        // (1 odd and 1 even always make an odd)
                        $temp .= $tokens[$j] . $delimiter;
                        // save memory.
                        $tokens[$j] = "";
                    }

                } // for..
            } // else
        }
    }

    return $output;
}