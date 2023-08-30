<?php

use App\Models\Users;
use App\Models\Activity_logs;
use App\Models\Lists;
use App\Models\userlists;
use App\Models\Subscribers;
use App\Models\Application_settings;
use App\Models\Countries;
use App\Models\MainMenus;
use Illuminate\Support\Facades\Mail;

if (!function_exists('theme')) {

    function theme() {
        return app(App\Core\Theme::class);
    }

}

if (!function_exists('getName')) {

    /**
     * Get product name
     *
     * @return void
     */
    function getName() {
        return config('settings.KT_THEME');
    }

}


if (!function_exists('addHtmlAttribute')) {

    /**
     * Add HTML attributes by scope
     *
     * @param $scope
     * @param $name
     * @param $value
     *
     * @return void
     */
    function addHtmlAttribute($scope, $name, $value) {
        theme()->addHtmlAttribute($scope, $name, $value);
    }

}


if (!function_exists('addHtmlAttributes')) {

    /**
     * Add multiple HTML attributes by scope
     *
     * @param $scope
     * @param $attributes
     *
     * @return void
     */
    function addHtmlAttributes($scope, $attributes) {
        theme()->addHtmlAttributes($scope, $attributes);
    }

}


if (!function_exists('addHtmlClass')) {

    /**
     * Add HTML class by scope
     *
     * @param $scope
     * @param $value
     *
     * @return void
     */
    function addHtmlClass($scope, $value) {
        theme()->addHtmlClass($scope, $value);
    }

}


if (!function_exists('printHtmlAttributes')) {

    /**
     * Print HTML attributes for the HTML template
     *
     * @param $scope
     *
     * @return string
     */
    function printHtmlAttributes($scope) {
        return theme()->printHtmlAttributes($scope);
    }

}


if (!function_exists('printHtmlClasses')) {

    /**
     * Print HTML classes for the HTML template
     *
     * @param $scope
     * @param $full
     *
     * @return string
     */
    function printHtmlClasses($scope, $full = true) {
        return theme()->printHtmlClasses($scope, $full);
    }

}


if (!function_exists('getSvgIcon')) {

    /**
     * Get SVG icon content
     *
     * @param $path
     * @param $classNames
     * @param $folder
     *
     * @return string
     */
    function getSvgIcon($path, $classNames = 'svg-icon', $folder = 'assets/media/icons/') {
        return theme()->getSvgIcon($path, $classNames, $folder);
    }

}


if (!function_exists('setModeSwitch')) {

    /**
     * Set dark mode enabled status
     *
     * @param $flag
     *
     * @return void
     */
    function setModeSwitch($flag) {
        
    }

}


if (!function_exists('isModeSwitchEnabled')) {

    /**
     * Check dark mode status
     *
     * @return void
     */
    function isModeSwitchEnabled() {
        
    }

}


if (!function_exists('setModeDefault')) {

    /**
     * Set the mode to dark or light
     *
     * @param $mode
     *
     * @return void
     */
    function setModeDefault($mode) {
        
    }

}


if (!function_exists('getModeDefault')) {

    /**
     * Get current mode
     *
     * @return void
     */
    function getModeDefault() {
        
    }

}


if (!function_exists('setDirection')) {

    /**
     * Set style direction
     *
     * @param $direction
     *
     * @return void
     */
    function setDirection($direction) {
        
    }

}


if (!function_exists('getDirection')) {

    /**
     * Get style direction
     *
     * @return void
     */
    function getDirection() {
        
    }

}


if (!function_exists('isRtlDirection')) {

    /**
     * Check if style direction is RTL
     *
     * @return void
     */
    function isRtlDirection() {
        
    }

}


if (!function_exists('extendCssFilename')) {

    /**
     * Extend CSS file name with RTL or dark mode
     *
     * @param $path
     *
     * @return void
     */
    function extendCssFilename($path) {
        
    }

}


if (!function_exists('includeFavicon')) {

    /**
     * Include favicon from settings
     *
     * @return string
     */
    function includeFavicon() {
        return theme()->includeFavicon();
    }

}


if (!function_exists('includeFonts')) {

    /**
     * Include the fonts from settings
     *
     * @return string
     */
    function includeFonts() {
        return theme()->includeFonts();
    }

}


if (!function_exists('getGlobalAssets')) {

    /**
     * Get the global assets
     *
     * @param $type
     *
     * @return array
     */
    function getGlobalAssets($type = 'js') {
        return theme()->getGlobalAssets($type);
    }

}


if (!function_exists('addVendors')) {

    /**
     * Add multiple vendors to the page by name. Refer to settings KT_THEME_VENDORS
     *
     * @param $vendors
     *
     * @return void
     */
    function addVendors($vendors) {
        theme()->addVendors($vendors);
    }

}


if (!function_exists('addVendor')) {

    /**
     * Add single vendor to the page by name. Refer to settings KT_THEME_VENDORS
     *
     * @param $vendor
     *
     * @return void
     */
    function addVendor($vendor) {
        theme()->addVendor($vendor);
    }

}


if (!function_exists('addJavascriptFile')) {

    /**
     * Add custom javascript file to the page
     *
     * @param $file
     *
     * @return void
     */
    function addJavascriptFile($file) {
        theme()->addJavascriptFile($file);
    }

}


if (!function_exists('addCssFile')) {

    /**
     * Add custom CSS file to the page
     *
     * @param $file
     *
     * @return void
     */
    function addCssFile($file) {
        theme()->addCssFile($file);
    }

}


if (!function_exists('getVendors')) {

    /**
     * Get vendor files from settings. Refer to settings KT_THEME_VENDORS
     *
     * @param $type
     *
     * @return array
     */
    function getVendors($type) {
        return theme()->getVendors($type);
    }

}


if (!function_exists('getCustomJs')) {

    /**
     * Get custom js files from the settings
     *
     * @return array
     */
    function getCustomJs() {
        return theme()->getCustomJs();
    }

}


if (!function_exists('getCustomCss')) {

    /**
     * Get custom css files from the settings
     *
     * @return array
     */
    function getCustomCss() {
        return theme()->getCustomCss();
    }

}


if (!function_exists('getHtmlAttribute')) {

    /**
     * Get HTML attribute based on the scope
     *
     * @param $scope
     * @param $attribute
     *
     * @return array
     */
    function getHtmlAttribute($scope, $attribute) {
        return theme()->getHtmlAttribute($scope, $attribute);
    }

}

if (!function_exists('isUrl')) {

    /**
     * Get HTML attribute based on the scope
     *
     * @param $url
     *
     * @return mixed
     */
    function isUrl($url) {
        return filter_var($url, FILTER_VALIDATE_URL);
    }

}

if (!function_exists('image')) {

    /**
     * Get image url by path
     *
     * @param $path
     *
     * @return string
     */
    function image($path) {
        return asset('assets/media/' . $path);
    }

}

if (!function_exists('getAdminSettings')) {

    function getAdminSettings() {
        $settingData = Application_settings::select('setting_name', 'setting_value')->get()->toArray();
        $settingDataArray = array();
        foreach ($settingData as $val) {
            $settingDataArray[$val['setting_name']] = $val['setting_value'];
        }
        return $settingDataArray;
    }

}

if (!function_exists('getUserRow')) {

    function getUserRow($user_id) {
        return $result = Users::where('users.id', $user_id)->select('users.id as user_id', 'users.*', "users.token as api_token")->first()->toArray();
    }

}

if (!function_exists('getClientProfileLink')) {

    function getClientProfileLink($adminModule, $userRow) {
        $clientAddress = url('admin/account-settings') . '/' . $userRow['id'];
        $clientLink = "<a href='" . $clientAddress . "'>" . $userRow['name'] . "</a>";
        return $adminModule = str_replace("%%client_link%%", $clientLink, $adminModule);
    }

}
if (!function_exists('saveLog')) {

    function saveLog($data) {
        if ((key_exists("admin_id", $data) && $data['admin_id'] > 0) || (key_exists("user_id", $data) && $data['user_id'] > 1)) {
            $objActivityLog = new Activity_logs;
            $objActivityLog->fill($data);
            $objActivityLog->save();
        }
    }

}
if (!function_exists('deleteSubscribers')) {

    function deleteSubscribers($groupID) {
        DB::table('mobile_subscribers')
                ->where('group_id', $groupID)
                ->update([
                    'is_deleted' => 1
        ]);
        DB::table('groups')->where('id', $groupID)->update([
            'no_of_contacts' => 0
        ]);
    }

}
if (!function_exists('DeleteGroup')) {

    function DeleteGroup($groupID) {

        DB::table('groups')
                ->where('id', $groupID)
                ->update([
                    'is_deleted' => 1,
                    'updated_at' => date("Y-m-d H:i:s")
        ]);
    }

}
if (!function_exists('getListName')) {

    function getListName($ListName) {
        $i = 1;
        while ($count = DB::table('lists')->where('list_name', $ListName . $i)->count() > 0) {
            $i++;
        }
        return $ListName . ' ' . $i;
    }

}
if (!function_exists('updateListSubscriberCount')) {

    function updateListSubscriberCount($updateListArray = array()) {
        $result = userlists::select('id');
        if (count($updateListArray) > 0)
            $result->whereIn('id', $updateListArray);

        $listData = $result->get()->toArray();

        foreach ($listData as $list) {
            $subscriberCount = Subscribers::where('list_id', $list['id'])->count();
            $listData = array(
                'no_of_contacts' => $subscriberCount
            );
            $objUserlist = userlists::find($list['id']);
            $objUserlist->fill($listData);
            $objUserlist->save();
        }
    }

}
if (!function_exists('increaseDbCount')) {

    function increaseDbCount($listId) {
        DB::table('lists')
                ->where('id', $listId)
                ->increment('no_of_contacts', 1);
    }

}

if (!function_exists('getNoofRowsinFile')) {

    function getNoofRowsinFile($file) {
        //print $file ."<br>" ; exit;
        $total_rec = 0;
        $handle = @fopen($file, "r");
        while (!feof($handle)) {
            $line = fgets($handle, 4096);
            $total_rec = $total_rec + substr_count($line, "\n");
        }
        return $total_rec;
    }

}

if (!function_exists('getIp')) {

    function getIp() {
        foreach (array(
    'HTTP_CLIENT_IP',
    'HTTP_X_FORWARDED_FOR',
    'HTTP_X_FORWARDED',
    'HTTP_X_CLUSTER_CLIENT_IP',
    'HTTP_FORWARDED_FOR',
    'HTTP_FORWARDED',
    'REMOTE_ADDR'
        ) as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP/* , FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE */) !== false) {
                        return $ip;
                    }
                }
            }
        }
        return null;
    }

}

if (!function_exists('rspecial')) {

    function rspecial($string, $rp = '') {
        if ($string != "" && strlen($string) > 1) {
            if ($string[0] == 0 && $string[1] == 0)
                $string = substr($string, 2);
        }
        $string = str_replace('-', '', $string);
        $string = str_replace('-', '', $string);
        $string = str_replace(' ', '', $string);
        $string = str_replace('+', '', $string);
        $string = str_replace('.', '', $string);

        return preg_replace('/[^0-9\-]/', $rp, $string);
    }

}
if (!function_exists('random_string')) {

    function random_string($length) {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }

}
if (!function_exists('getUserIp')) {

    function getUserIp() {
        $ip = $_SERVER['REMOTE_ADDR'];

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        return $ip;
    }

}
if (!function_exists('createMenu')) {

    function createMenu() {
        $result = MainMenus::where(array('parent_id' => 0));
        $mainMenu = '';
        if ($result->count() > 0) {
            $parentMenu = $result->orderBy('sequence', "ASC")->select("id", "parent_id", "module_name", "routes", "child_routes", "link", "sequence", "icons", "is_view", "is_movable")->get()->toArray();

            $i = 0;
            foreach ($parentMenu as $parentRow) {
                $parentRouteArray = explode("||", $parentRow['child_routes']);
                $currentRouteClass = (in_array(Route::currentRouteName(), $parentRouteArray)) ? "hover show" : "";

                //if($i==0)
                $mainMenu .= '<div data-kt-menu-trigger="click" class="menu-item menu-accordion ' . $currentRouteClass . '">';

                $mainMenu .= '<span class="menu-link">';
                $mainMenu .= '<span class="menu-icon">';
                $mainMenu .= '<span class="svg-icon svg-icon-2">';
                $mainMenu .= $parentRow['icons'];
                $mainMenu .= '</span>';
                $mainMenu .= '</span>';
                $mainMenu .= '<span class="menu-title">' . trans($parentRow['module_name']) . '</span>';
                $mainMenu .= '<span class="menu-arrow"></span>';
                $mainMenu .= '</span>';
                $resultSub = MainMenus::where(array('parent_id' => $parentRow['id']));
                if ($resultSub->count() > 0) {
                    $subMenuData = $resultSub->orderBy('sequence', "ASC")->select("id", "parent_id", "module_name", "routes", "routes", "child_routes", "link", "sequence", "icons", "is_view", "is_movable")->get()->toArray();
                    foreach ($subMenuData as $subMenuRow) {

                        $parentRouteArray1 = explode("||", $subMenuRow['child_routes']);
                        $currentRouteClass1 = (in_array(Route::currentRouteName(), $parentRouteArray1)) ? "hover show" : "";
                        if ($subMenuRow['link'] == '#') {
                            $mainMenu .= '<div class="menu-sub menu-sub-accordion menu-active-bg">';
                            $mainMenu .= '<div data-kt-menu-trigger="click" class="menu-item menu-accordion ' . $currentRouteClass1 . '">';
                            $mainMenu .= '<span class="menu-link">';
                            $mainMenu .= '<span class="menu-bullet">';
                            $mainMenu .= '<span class="bullet bullet-dot"></span>';
                            $mainMenu .= '</span>';
                            $mainMenu .= '<span class="menu-title">' . trans($subMenuRow['module_name']) . '</span>';
                            $mainMenu .= '<span class="menu-arrow"></span>';
                            $mainMenu .= '</span>';
                            //submenu here
                            $resultSub1 = MainMenus::where(array('parent_id' => $subMenuRow['id']));
                            if ($resultSub1->count() > 0) {
                                $subMenuData1 = $resultSub1->orderBy('sequence', "ASC")->select("id", "parent_id", "module_name", "routes", "routes", "child_routes", "link", "sequence", "icons", "is_view", "is_movable")->get()->toArray();
                                $mainMenu .= '<div class="menu-sub menu-sub-accordion menu-active-bg">';
                                foreach ($subMenuData1 as $subMenuRow1) {
                                    $parentRouteArray2 = explode("||", $subMenuRow1['child_routes']);
                                    $currentRouteClass2 = (in_array(Route::currentRouteName(), $parentRouteArray2)) ? "here show" : "";
                                    $mainMenu .= '<div class="menu-item ' . $currentRouteClass2 . '">';
                                    $mainMenu .= '<a class="menu-link" href="' . route($subMenuRow1['routes']) . '">';
                                    $mainMenu .= '<span class="menu-bullet">';
                                    $mainMenu .= '<span class="bullet bullet-dot"></span>';
                                    $mainMenu .= '</span>';
                                    $mainMenu .= '<span class="menu-title">' . trans($subMenuRow1['module_name']) . '</span>';
                                    $mainMenu .= '</a>';
                                    $mainMenu .= '</div>';
                                }
                                $mainMenu .= '</div>';
                            }

                            $mainMenu .= '</div>';
                            $mainMenu .= '</div>';
                        } else {
                            $mainMenu .= '<div class="menu-sub menu-sub-accordion menu-active-bg">';
                            $active = Route::currentRouteName() == $subMenuRow['routes'] ? ' active' : "";
                            $mainMenu .= '<a class="menu-link' . $active . '" href="' . route($subMenuRow['routes']) . '">';
                            $mainMenu .= '<span class="menu-bullet">';
                            $mainMenu .= '<span class="bullet bullet-dot"></span>';
                            $mainMenu .= '</span>';
                            $mainMenu .= '<span class="menu-title">' . trans($subMenuRow['module_name']) . '</span>';
                            $mainMenu .= '</a>';
                            $mainMenu .= '</div>';
                        }
                    }
                }
                //if($i==0)
                $mainMenu .= '</div>';
                $i++;
            }
        }
        return $mainMenu;
    }

}
if (!function_exists('getFieldValue')) {

    function getFieldValue($table, $field, $where = "") {
        $result = DB::table($table)->select($field);
        $fieldvalue = '';
        if ($where != "")
            $result->where($where);
        if ($result->count() > 0) {
            $row = $result->first();
            $fieldvalue = $row->$field;
        }
        return $fieldvalue;
    }

}
if (!function_exists('getMenuTree')) {

    function getMenuTree($category_id, $categories = []) {
        // Retrieve the current category by ID
        $category = getMenuById($category_id);

        // If the current category exists
        if ($category) {
            // Add the current category to the list of categories
            $categories[] = $category;

            // If the current category has a parent category
            if ($category['parent_id'] != 0) {
                // Recursively call the function with the parent category ID
                return getMenuTree($category['parent_id'], $categories);
            }
        }
        // If there are no more parent categories, return the list of categories
        return array_reverse($categories);
    }

}
if (!function_exists('getMenuById')) {

    function getMenuById($id) {
        $row = array();
        $rs = MainMenus::where('id', $id)->select('id', 'parent_id', 'module_name', 'link', 'routes');
        if ($rs->count() > 0) {
            $row = $rs->first()->toArray();
        }
        return $row;
    }

}
if (!function_exists('getMenuByRoute')) {

    function getMenuByRoute($route) {
        $row = array();
        $rs = MainMenus::where('routes', $route)->select('id', 'parent_id', 'module_name', 'link', 'routes');
        if ($rs->count() > 0) {
            $row = $rs->first()->toArray();
        }
        return $row;
    }

}
if (!function_exists('getMenuTreeByLastChild')) {

    function getMenuTreeByLastChild($route) {
        $menuTree = array();
        $row = getMenuByRoute($route);
        if ($row) {
            $menuTree = getMenuTree($row['id']);
        }
        return $menuTree;
    }

}
if (!function_exists('getBreadCrums')) {

    function getBreadCrums() {
        $route = Route::currentRouteName();
        $menuTree = getMenuTreeByLastChild($route);
        $html = '<li class="breadcrumb-item text-muted">
          <a href="' . url("/") . '" class="text-muted text-hover-primary">Home</a>
        </li>';
        foreach ($menuTree as $row) {
            /*echo '<pre>';
            print_r($row);
            exit;
            */
            $html .= '<li class="breadcrumb-item">
          <span class="bullet bg-gray-400 w-5px h-2px"></span>
        </li>';
            if ($row['link'] == "#") {
                $html .= '<li class="breadcrumb-item text-muted">' . trans($row['module_name']) . '</li>';
            } else {
                $html .= '<li class="breadcrumb-item text-muted">
          <a href="' . url($row['link']) . '" class="text-muted text-hover-primary">' . trans($row['module_name']) . '</a>
        </li>';
            }
        }
        return $html;
    }

}

if (!function_exists('replaceClientVariables')) {

    function replaceClientVariables($body, $clientID, $client = "") {
        $adminSetting = getAdminSettings();
        $clientVariables = array('first_name', 'last_name', 'name', 'email', 'city', 'state', 'zip', 'country', 'phone', 'mobile_no', 'address', 'status', 'time_zone', 'signup_ip');
        $clientResult = Users::where('id', $clientID)->select($clientVariables);
        if ($clientResult->count() > 0) {
            $clientData = $clientResult->first()->toArray();
            foreach ($clientVariables as $variable) {
                if ($variable == 'country') {
                    $countryData = Countries::where('country_code', $clientData['country'])->select('country_name')->first()->toArray();
                    $body = ($client != "") ? str_replace('%%client_country%%', $countryData['country_name'], $body) : str_replace('%%country%%', $countryData['country_name'], $body);
                } else {
                    $body = ($client != "") ? str_replace('%%client_' . $variable . '%%', $clientData[$variable], $body) : str_replace('%%' . $variable . '%%', $clientData[$variable], $body);
                }
            }
        }
        $body = str_replace('%%login_url%%', $adminSetting['installation_domain'] . '/login', $body);
        $body = str_replace('%%support_email%%', $adminSetting['reporting_email'], $body);
        return $body;
    }

}

if (!function_exists('replaceClientVariableWithBlankValue')) {

    function replaceClientVariableWithBlankValue($body, $blankVariables) {
        foreach ($blankVariables as $variable) {
            $body = str_replace("%%" . $variable . "%%", "", $body);
        }
        return $body;
    }

}
if (!function_exists('replaceClientDefaultSettingVariables')) {

    function replaceClientDefaultSettingVariables($body) {
        $adminSetting = getAdminSettings();
        $siteUrl = '<a href="' . $adminSetting['installation_domain'] . '"  target="_blank"> ' . $adminSetting['installation_domain'] . '</a>';
        $body = str_replace("%%site_link%%", $siteUrl, $body);
        return $body = str_replace("%%site_url%%", $adminSetting['installation_domain'], $body);
    }

}

if (!function_exists('sendSimpleEmail')) {

    function sendSimpleEmail($to, $from, $fromName, $subject, $message) {

        $adminSetting = getAdminSettings();
        if (@$adminSetting['smtp_email'] == 'on') {
            $user = array(
                'to' => $to,
                'from' => $from,
                'subject' => $subject,
                'from_name' => $fromName
            );

            $encryption_method = ($adminSetting['encryption_method'] == 'None') ? "" : $adminSetting['encryption_method'];

            try {
                Mail::send('emails', ['body' => $message], function ($m) use ($user) {

                    $m->from($user['from'], $user['from_name']);
                    $m->to($user['to'], $user['to'])->subject($user['subject']);
                });
                return true;
            } catch (\Exception $e) {
                Log::info("error:" . $e->getMessage());
                return false;
            }
        } else {

            $header = "Reply-To: Support <$from>\r\n";

            $header .= "Return-Path: Support <$from>\r\n";
            $header .= "From: $fromName <$from>\r\n";
            $header .= "Organization: getFreexBoxLiveCodes\r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            @mail("$to", "$subject", "$message", $header);
        }
    }

}

if (!function_exists('getAdminProfileLink')) {

    function getAdminProfileLink($adminModule) {

        $adminAddress = url('admin/create-admin') . '/' . session()->get('admin_id');
        $adminLink = "<a href='" . $adminAddress . "'>" . session()->get('admin_first_name') . "</a>";
        return $adminModule = str_replace("%%admin_link%%", $adminLink, $adminModule);
    }

}