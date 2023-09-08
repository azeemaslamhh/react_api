<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Models\Groups;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Customfields;
use App\Models\GroupCustomFields;

//use Illuminate\Support\Facades\Crypt;

class CustomFieldsController extends BaseController {

    public function __construct() {
        
    }

    public function getAllCustomFields(Request $request) {
        try {
            $addList = [
                'user_id' => 'required|integer',
            ];
            $validator = Validator::make($request->all(), $addList);
            if ($validator->fails()) {
                $messages = $validator->errors()->messages();
                return response()->json(array('status' => 'fail', 'message' => "validation failed", "data" => $messages, 'code' => 700), 200);
            }
            $user_id = $request->user_id;
            ///$result = Lists::where('user_id', $user_id)->where('is_deleted', 0);
            $result = Customfields::where(array('user_id' => $request->user_id, 'is_deleted' => 0, 'is_default' => 0));
            $customfieldsData = array();
            if ($result->count() > 0) {
                $customfieldsData = $result->orderBy('field_order', "ASC")->get()->toArray();
                $status = 'success';
                $message = "";
                $code = 200;
            } else {
                $status = 'no_record';
                $message = 'no custom feield exist';
                $code = 701;
            }
            return response()->json([
                        'status' => $status,
                        'message' => $message,
                        'customfieldsData' => $customfieldsData,
                        'code' => $code
                            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                        'status' => 'exception',
                        'message' => $e->getMessage(),
                        'code' => '500'
                            ], 500);
        }

        //'required'     => 'integer|min:0|max:1',
    }

    public function getAllAdditionalFields(Request $request) {
        try {
            $addList = [
                'user_id' => 'required|integer',
            ];
            $validator = Validator::make($request->all(), $addList);
            if ($validator->fails()) {
                $messages = $validator->errors()->messages();
                return response()->json(array('status' => 'fail', 'message' => "validation failed", "data" => $messages, 'code' => 700), 200);
            }
            $user_id = $request->user_id;
            ///$result = Lists::where('user_id', $user_id)->where('is_deleted', 0);
            $result = Customfields::where(array('is_deleted' => 0, 'is_default' => 1));
            $customfieldsData = array();
            if ($result->count() > 0) {
                $customfieldsData = $result->orderBy('field_order', "ASC")->get()->toArray();
                $status = 'success';
                $message = "";
                $code = 200;
            } else {
                $status = 'no_record';
                $message = 'no custom feield exist';
                $code = 701;
            }
            return response()->json([
                        'status' => $status,
                        'message' => $message,
                        'customfieldsData' => $customfieldsData,
                        'code' => $code
                            ], 200);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                        'status' => 'exception',
                        'message' => $e->getMessage(),
                        'customfieldsData' => array(),
                        'code' => $code
                            ], 500);
        }

        //'required'     => 'integer|min:0|max:1',
    }

    public function getAllFields(Request $request) {
        try {
            $addList = [
                'user_id' => 'required|integer',
            ];
            $validator = Validator::make($request->all(), $addList);
            if ($validator->fails()) {
                $messages = $validator->errors()->messages();
                return response()->json(array('status' => 'fail', 'message' => "validation failed", "data" => $messages, 'code' => 700), 200);
            }
            $user_id = $request->user_id;
            ///$result = Lists::where('user_id', $user_id)->where('is_deleted', 0);
            $resultAdditional = Customfields::where(array('is_deleted' => 0, 'is_default' => 1));
            $additionalfieldsData = array();
            if ($resultAdditional->count() > 0) {
                $additionalfieldsData = $resultAdditional->orderBy('field_order', "ASC")->get()->toArray();
                $additionalFieldStatus = 'success';
                $additionalMessage = "";
            } else {
                $additionalFieldStatus = 'no_record';
                $additionalMessage = 'no custom feield exist';
            }

            $result = Customfields::where(array('is_deleted' => 0, 'is_default' => 0));
            $customfieldsData = array();
            if ($result->count() > 0) {
                $customfieldsData = $result->orderBy('field_order', "ASC")->get()->toArray();
                $customFieldStatus = 'success';
                $customMessage = "";
            } else {
                $customFieldStatus = 'no_record';
                $customMessage = 'no custom feield exist';
            }
            return response()->json([
                        'status' => 'success',
                        'additionalFieldStatus' => $additionalFieldStatus,
                        'additionalMessage' => $additionalMessage,
                        'additionalfieldsData' => $additionalfieldsData,
                        'customFieldStatus' => $customFieldStatus,
                        'customMessage' => $customMessage,
                        'customfieldsData' => $customfieldsData,
                        'message' => '',
                        'code' => 200
                            ], 200);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                        'status' => 'exception',
                        'message' => $e->getMessage(),
                        'additionalFieldStatus' => "exception",
                        'additionalMessage' => "",
                        'additionalfieldsData' => array(),
                        'customFieldStatus' => "exception",
                        'customMessage' => "",
                        'customfieldsData' => array(),
                        'code' => 200
                            ], 500);
        }

        //'required'     => 'integer|min:0|max:1',
    }

    public function getCustomFields(Request $request) {


        $addList = [
            'user_id' => 'required|integer',
            'page' => 'required',
            'items_per_page' => 'required|integer|min:1|max:100',
        ];
        //'required'     => 'integer|min:0|max:1',
        $validator = Validator::make($request->all(), $addList);
        if ($validator->fails()) {
            $messages = $validator->errors()->messages();
            return response()->json(array('status' => 'false', 'message' => "validation failed", "data" => $messages, 'code' => 700), 200);
        }

        $items_per_page = $request->items_per_page;
        $page = (int) $request->page;
        $skip = $items_per_page * ($page - 1);

        /*
          echo '<pre>';
          print_r($request->bearerToken());
          exit;
         */
        try {
            $user_id = $request->user_id;
            ///$result = Lists::where('user_id', $user_id)->where('is_deleted', 0);
            $result = Customfields::where(array('user_id' => $request->user_id, 'is_deleted' => 0, 'is_default' => 0));

            $sKeywords = $request->get('search');
            if ($sKeywords != "") {
                $result->Where(function ($query) use ($sKeywords) {
                    $query->Where('field_name', 'LIKE', "%{$sKeywords}%")->Where('field_type', 'LIKE', "%{$sKeywords}%")->Where('field_order', 'LIKE', "%{$sKeywords}%");
                });
            }




            $count = $result->count();
            $last_page = 1;
            $links = array();
            $DBpage = (int) $request->page;
            if ($count > 0) {

                $last_page = ceil($count / $items_per_page);
                $prePage = $page - 1;
                $pUrl = ($page == 1 || $items_per_page >= $count) ? null : "/?page=" . $prePage;
                $p = ($page == 1) ? null : $prePage;
                if ($DBpage > 1) {
                    $row = array(
                        'url' => "/?page=1",
                        'label' => 'First',
                        'active' => false,
                        'page' => 1
                    );
                    $links[] = $row;
                }


                $row = array(
                    'url' => $pUrl,
                    'label' => 'Previous',
                    'active' => false,
                    'page' => $p
                );
                $links[] = $row;

                $paginations = array();
                for ($i = 1; $i <= $last_page; $i++) {
                    $paginations[] = $i;
                }
                if ($last_page == $DBpage && $count <= $items_per_page) {
                    $row = array(
                        'url' => ' /?page=1',
                        'label' => 1,
                        'active' => true,
                        'page' => 1,
                    );
                    $links[] = $row;
                }
                if ($DBpage == 1 && in_array(2, $paginations)) {
                    $row = array(
                        'url' => ' /?page=' . $DBpage,
                        'label' => $DBpage,
                        'active' => true,
                        'page' => $DBpage,
                    );
                    $links[] = $row;
                }

                if ($DBpage == 1 && in_array(2, $paginations)) {
                    $nextPageUrl = 2;
                    $row = array(
                        'url' => ' /?page=2',
                        'label' => 2,
                        'active' => false,
                        'page' => 2,
                    );
                    $links[] = $row;
                }

                if ($DBpage == 1 && in_array(3, $paginations)) {
                    $nextPageUrl = 2;
                    $row = array(
                        'url' => ' /?page=3',
                        'label' => 3,
                        'active' => false,
                        'page' => 3,
                    );
                    $links[] = $row;
                }
                if ($DBpage == 1) {
                    $row = array(
                        'url' => $count > $items_per_page ? "/?page=2" : null,
                        'label' => "Next",
                        'active' => false,
                        'page' => $count > $items_per_page ? 2 : Null
                    );
                    $links[] = $row;
                }
                if ($last_page > 1 && $DBpage > 1 && $DBpage != $last_page) {
                    $prePage = (int) $DBpage - 1;
                    if (in_array($prePage, $paginations)) {

                        $row = array(
                            'url' => ' /?page=' . $prePage,
                            'label' => $prePage,
                            'active' => false,
                            'page' => $prePage,
                        );
                        $links[] = $row;
                    }

                    $row = array(
                        'url' => ' /?page=' . $DBpage,
                        'label' => $DBpage,
                        'active' => true,
                        'page' => $DBpage,
                    );
                    $links[] = $row;

                    if ($last_page > 1 && $DBpage < $last_page) {
                        $nextDB = (int) $DBpage + 1;
                        if (in_array($nextDB, $paginations)) {

                            $row = array(
                                'url' => ' /?page=' . $nextDB,
                                'label' => $nextDB,
                                'active' => false,
                                'page' => $nextDB,
                            );
                        }
                        $nextPageUrl = $DBpage + 1;
                        if (in_array($nextPageUrl, $paginations)) {

                            $row = array(
                                'url' => ' /?page=' . $nextPageUrl,
                                'label' => $nextPageUrl,
                                'active' => false,
                                'page' => $nextPageUrl,
                            );
                            $links[] = $row;
                            ///$nextPageUrl = $DBpage + 1;
                            $row = array(
                                'url' => "/?page=" . $nextPageUrl,
                                'label' => "Next",
                                'active' => false,
                                'page' => $nextPageUrl
                            );
                            $links[] = $row;
                        }
                    }
                }


                if ($page == $last_page && $DBpage > 1) {
                    $nextDBpage = $DBpage - 2;
                    if (in_array($nextDBpage, $paginations)) {
                        $row = array(
                            'url' => ' /?page=' . $nextDBpage,
                            'label' => $nextDBpage,
                            'active' => false,
                            'page' => $nextDBpage,
                        );
                        $links[] = $row;
                    }
                    $nextDBpage = $DBpage - 1;
                    if (in_array($nextDBpage, $paginations)) {
                        $row = array(
                            'url' => ' /?page=' . $nextDBpage,
                            'label' => $nextDBpage,
                            'active' => false,
                            'page' => $nextDBpage,
                        );
                        $links[] = $row;
                    }
                    $row = array(
                        'url' => ' /?page=' . $DBpage,
                        'label' => $DBpage,
                        'active' => true,
                        'page' => $DBpage,
                    );
                    $links[] = $row;
                    $row = array(
                        'url' => NULL,
                        'label' => "Next",
                        'active' => false,
                        'page' => null
                    );
                    $links[] = $row;
                }
                if ($DBpage != $last_page) {
                    $row = array(
                        'url' => "/?page=" . $last_page,
                        'label' => 'Last',
                        'active' => false,
                        'page' => $last_page
                    );
                    $links[] = $row;
                }
            }
            // echo '<pre>';
            ///   print_r($links); exit;

            $customfieldsData = array();

            $page = (int) $page;
            if ($page > 1) {
                $pre = $page - 1;
                $prev_page_url = '/?page=' . $pre;   //.$page-1
            } else {
                $prev_page_url = null;
            }
            /// die("ddd");
            //$prev_page_url = ($page===1) ? "":"/?page=".$page+1;  die("ccc");
            $next = $page + 1;
            $next_page_url = ($page == $last_page) ? null : "/?page=" . $next;
            $from = $skip + 1;
            $to = ($page == $last_page) ? $count : $from + $items_per_page;
            if ($to > $count) {
                $to = $count;
                ///$next_page_url = NULL;
            }

            if ($items_per_page >= $count) {
                $next_page_url = null;
                $prev_page_url = null;
                $from = 1;
            }
            /// die("ccc");
            $payload = array(
                'pagination' => array(
                    'page' => $page,
                    'first_page_url' => '/?page=1',
                    'from' => $from,
                    'last_page' => $last_page,
                    'links' => $links,
                    'next_page_url' => $next_page_url,
                    'items_per_page' => $request->items_per_page,
                    'prev_page_url' => $prev_page_url,
                    'to' => $to,
                    'total' => $count
                )
            );

            if ($count > 0) {
                $customfieldsData = $result->orderBy('field_order', "ASC")->skip($skip)->take($items_per_page)->get()->toArray();
                /* foreach ($customfieldsDataArray as $customfieldsRow) {
                  $resultCustomlists = GroupCustomFields::where('custom_field_id', $customfieldsRow['id']);
                  $customGroups = array();
                  if ($resultCustomlists->count() > 0) {
                  $customGroups = $resultCustomlists->first()->toArray();
                  }
                  $customfieldsRow['group_custom_fields'] = $customGroups;
                  $customfieldsData[] = $customfieldsRow;
                  }
                 */
                $code = 200;
                $message = "";
                $status = 'success';
            } else {
                $code = 701;
                $message = trans('client.no_record_found');
                $status = 'no_record_found';
            }
            $data = array(
                'status' => $status,
                'message' => $message,
                'data' => $customfieldsData,
                'payload' => $payload,
                'code' => $code
            );
            return response()->json($data, 200);
        } catch (\Exception $e) {

            return response()->json([
                        'status' => "Exception",
                        'message' => $e->getMessage(),
                        'code' => 500
                            ], 500);
        }
    }

    public function addCustomFields(Request $request) {

        try {
            $requireCutomFields = [
                'user_id' => 'required',
                'field_name' => 'required',
                'field_type' => 'required',
                'is_required' => 'required',
                'field_order' => 'required',
            ];
            if (!empty($request->field_type) && ($request->field_type == 'checkbox' || $request->field_type == 'select' || $request->field_type == 'radio')) {
                $requireCutomFields['value_list'] = 'required';
            }
            $validator = Validator::make($request->all(), $requireCutomFields);

            if ($validator->fails()) {
                $messages = $validator->errors()->messages();
                return response()->json(array('status' => 'false', 'message' => "validation failed", "data" => $messages, 'code' => 700), 200);
            }
            $id = $request->get('id') ? $request->get('id') : 0;

            $group_ids = array();

            $value_list = empty($request->value_list) ? "" : $request->value_list;

            $data = [
                'field_name' => $request->field_name,
                'field_type' => $request->field_type,
                'is_required' => $request->is_required,
                'value_list' => $value_list,
                'field_order' => $request->field_order,
                'user_id' => $request->user_id
            ];

            if ($id > 0) {
                $count = Customfields::where(array('is_deleted' => 0, 'id' => $id))->count();
                $objCus = Customfields::find($id);
                if ($count == 0) {
                    $status = 'record_not_exist';
                    $message = trans('id not exist');
                    $code = 701;
                    return response()->json([
                                'status' => $status,
                                'message' => $message,
                                'code' => $code
                                    ], 200);
                } else {
                    $logData = [
                        'module' => trans('file.activity_logs.custom_field.update'),
                        'operation' => 'Update',
                        'user_id' => $request->user_id
                    ];
                    $message = trans('client.notification.updated.custome_field');
                }
            } else {
                $data['create_date'] = date('Y-m-d');
                $message = trans('client.notification.created.custome_field');
                $objCus = new Customfields;
                $logData = [
                    'module' => trans('file.activity_logs.custom_field.insert'),
                    'operation' => 'Insert',
                    'user_id' => $request->user_id
                ];
            }
            $objCus->fill($data);
            if ($objCus->save()) {
                if ($id > 0) {
                    $custom_field_id = $id;
                    $adminModule = trans('client.activity_logs_admin.custom_field.update');
                } else {
                    $custom_field_id = $objCus->id;
                    $adminModule = trans('client.activity_logs_admin.custom_field.insert');
                }
                $logData['module_name'] = 'custom_field';
                $logData['module_id'] = $custom_field_id;
                $userRow = getUserRow($request->user_id);
                $adminModule = getClientProfileLink($adminModule, $userRow);

                $customFieldAddress = url('admin/view-custom-field') . '/' . $custom_field_id;
                $customFieldAddressLink = "<a href='" . $customFieldAddress . "'>" . $request->field_name . "</a>";
                $module = str_replace("%%custom_field_link%%", $customFieldAddressLink, $adminModule);
                $logData['admin_log'] = $module;

                saveLog($logData);
                $code = 200;
                $status = 'success';
            } else {
                $status = 'fail';
                $message = trans('file.errors.msg');
                $code = 702;
            }
            $message = str_replace("%%custome_field%%", $request->field_name, $message);
            return response()->json([
                        'status' => $status,
                        'message' => $message,
                        'code' => $code
                            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                        'status' => 'Exception',
                        'message' => $e->getMessage(),
                        'code' => 500
                            ], 500);
        }


        //return response()->json(array('status' => $status, 'message' => $message), 200);
        ///echo json_encode(array('status' => $status, 'message' => $message));
    }

    public function getAdditionalFields(Request $request) {



        $addList = [
            'user_id' => 'required|integer',
        ];
        //'required'     => 'integer|min:0|max:1',
        $validator = Validator::make($request->all(), $addList);
        if ($validator->fails()) {
            $messages = $validator->errors()->messages();
            return response()->json(array('status' => 'false', 'message' => "validation failed", "data" => $messages, 'code' => 700), 200);
        }

        $items_per_page = $request->items_per_page;
        $page = (int) $request->page;
        $skip = $items_per_page * ($page - 1);

        try {
            $user_id = $request->user_id;
            $result = Customfields::where(array('user_id' => $user_id, 'is_deleted' => 0, 'is_default' => 1));

            $count = $result->count();

            $customfieldsData = array();
            $status = 'no_record';
            $message = 'No custom field found';
            if ($count > 0) {
                $status = 'success';
                $message = '';
                $customfieldsData = $result->select('custom_fields.id', 'custom_fields.is_required', 'custom_fields.field_type', 'custom_fields.field_name', 'custom_fields.is_required', 'custom_fields.value_list', 'custom_fields.field_order', 'custom_fields.created_at')->orderBy('custom_fields.field_order', "ASC")->get()->toArray();
                /* foreach ($customfieldsDataArray as $customfieldsRow) {
                  $resultCustomGroups = GroupCustomFields::where('custom_field_id', $customfieldsRow['id']);
                  $customlists = array();
                  if ($resultCustomGroups->count() > 0) {
                  $customlists = $resultCustomGroups->get()->toArray();
                  }
                  $customfieldsRow['created_at'] = date("M j, Y, g:i a", strtotime($customfieldsRow['created_at']));
                  $customfieldsRow['list_custom_fields'] = $customlists;
                  $customfieldsData[] = $customfieldsRow;
                  } */
                $code = 200;
            } else {
                $code = 701;
            }

            return response()->json(['status' => $status, 'message' => $message, 'additionalFieldsData' => $customfieldsData, 'code' => $code], 200);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                        'status' => 'exception',
                        'message' => $e->getMessage(),
                        'code' => 500
                            ], 500);
        }
    }

    public function getCustomFieldDetail(Request $request) {
        $customFieldsRow = array();
        try {
            $addList = [
                'user_id' => 'required|integer',
                'custom_field_id' => 'required|integer'
            ];
            $validator = Validator::make($request->all(), $addList);
            if ($validator->fails()) {
                $messages = $validator->errors()->messages();
                return response()->json(array('status' => 'fail', 'message' => "validation failed", "data" => $messages, 'code' => 700), 200);
            }
            $user_id = $request->user_id;
            ///$result = Lists::where('user_id', $user_id)->where('is_deleted', 0);
            $result = Customfields::where(array('user_id' => $request->user_id, 'is_deleted' => 0, 'is_default' => 0, 'id' => $request->custom_field_id));

            if ($result->count() > 0) {
                $customFieldsRow = $result->first()->toArray();
                /*
                  $resultCustomGroups = GroupCustomFields::where('custom_field_id', $customFieldsRow['id']);
                  $customlists = array();
                  if ($resultCustomGroups->count() > 0) {
                  $customlists = $resultCustomGroups->get()->toArray();
                  }
                  $customFieldsRow['group_custom_fields'] = $customlists;
                 */
                $status = 'success';
                $message = "";
                $code = 200;
            } else {
                $status = 'no_record';
                $message = trans('client.new_custom_field.id_not_ecxist');
                $code = 701;
            }
            return response()->json([
                        'status' => $status,
                        'message' => $message,
                        'customFieldsRow' => $customFieldsRow,
                        'code' => $code
                            ], 200);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                        'status' => 'exception',
                        'message' => $e->getMessage(),
                        'customFieldsRow' => array(),
                        'code' => 500
                            ], 500);
        }

        //'required'     => 'integer|min:0|max:1',
    }

    public function deleteCustomField(Request $request) {

        try {
            $addList = [
                'user_id' => 'required|integer',
                'id' => 'required',
            ];

            //'required'     => 'integer|min:0|max:1',
            $validator = Validator::make($request->all(), $addList);
            if ($validator->fails()) {
                $messages = $validator->errors()->messages();
                return response()->json(array('status' => 'fail', 'message' => "validation failed", "data" => $messages, 'code' => 700), 200);
            }

            $id = $request->get('id');
            $user_id = $request->get('user_id');
            $result = Customfields::where(array('user_id' => $request->user_id, 'is_deleted' => 0, 'is_default' => 0, 'id' => $request->id));

            if ($result->count() > 0) {
                DB::table('custom_fields')
                        ->where('id', $id)
                        ->update([
                            'is_deleted' => 1,
                            'updated_at' => date("Y-m-d H:i:s")
                ]);
                $customefieldRow = Customfields::where('id', $id)->select('field_name')->first()->toArray();
                $adminLog = trans('client.activity_logs_admin.custom_field.delete');
                $userRow = getUserRow($user_id);
                $adminModule = getClientProfileLink($adminLog, $userRow);
                $module = str_replace("%%custom_field%%", $customefieldRow['field_name'], $adminModule);

                $logData = [
                    'module' => trans('file.activity_logs.custom_field.delete'),
                    'operation' => 'Delete',
                    'admin_log' => $module,
                    'module_id' => $id,
                    'module_name' => 'custom_field',
                    'user_id' => $user_id,
                ];
                saveLog($logData);
                $message = trans('client.notification.deleted.custome_field');
                $message = str_replace("%%custome_field%%", $customefieldRow['field_name'], $message);
                $status = 'success';
                $code = 200;
            } else {
                $status = 'no_exist';
                $message = trans('client.new_custom_field.id_not_ecxist');
                $code = 701;
            }
            return response()->json([
                        'status' => $status,
                        'message' => $message,
                        'code' => $code
                            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                        'status' => 'exception',
                        'message' => $e->getMessage(),
                        'code' => '500'
                            ], 500);
        }
    }

    public function getGroupCustomFields(Request $request) {
        try {
            $addList = [
                'user_id' => 'required|integer',
                'group_id' => 'required|integer',
            ];
            $validator = Validator::make($request->all(), $addList);
            if ($validator->fails()) {
                $messages = $validator->errors()->messages();
                return response()->json(array('status' => 'fail', 'message' => "validation failed", "validation_errror" => $messages, 'code' => 700), 200);
            }
            $user_id = $request->user_id;
            $group_id = $request->group_id;
            $result = Groups::where(array('id' => $group_id, 'user_id' => $user_id, 'is_deleted' => 0));
            if ($result->count() == 0) {
                return response()->json(array('status' => 'fail', 'message' => trans('groups.group_does_not_exist'), "customfieldsData" => array(), 'code' => 701), 200);
            }
            $result = GroupCustomFields::join('custom_fields', 'group_custom_fields.custom_field_id', 'custom_fields.id')->where(array('group_custom_fields.group_id' => $group_id, 'group_custom_fields.is_deleted' => 0, 'custom_field.is_default' => 1));
            $additionalFeilds = array();
            $additionalFieldStatus = 'no_record';
            if ($result->count() > 0) {
                $additionalFieldStatus = 'success';
                $additionalFeilds = $result->select("custom_fields.*")->orderBy('custom_fields.field_order', "asc")->get()->toArray();
            }
            $resultC = GroupCustomFields::join('custom_fields', 'group_custom_fields.custom_field_id', 'custom_fields.id')->where(array('group_custom_fields.group_id' => $group_id, 'group_custom_fields.is_deleted' => 0, 'custom_fields.is_default' => 0));
            $customFeilds = array();
            $customFieldStatus = 'no_record';
            if ($resultC->count() > 0) {
                $customFieldStatus = 'success';
                $customFeilds = $resultC->select("custom_fields.*")->orderBy('custom_fields.field_order', "asc")->get()->toArray();
            }
            $status = 'success';
            $customfieldsData = array(
                'additionalFeilds' => $additionalFeilds,
                'customFeilds' => $customFeilds,
            );
            $message = "";
            return response()->json([
                        'status' => $status,
                        'message' => $message,
                        'customFieldStatus' => $customFieldStatus,
                        'additionalFieldStatus' => $additionalFieldStatus,
                        'customfieldsData' => $customfieldsData,
                        'code' => 200
                            ], 200);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                        'status' => 'exception',
                        'message' => $e->getMessage(),
                        'code' => 500,
                            ], 500);
        }

        //'required'     => 'integer|min:0|max:1',
    }

}
