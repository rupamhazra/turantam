<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'adminmanager/index';
$route['404_override'] = 'sitemanager/pagenotfound';
$route['translate_uri_dashes'] = FALSE;
$route['404']='sitemanager/pagenotfound';

/*require_once( BASEPATH .'database/DB.php' );
$db =& DB();
$db->where('is_active=','active');
$query = $db->get('pages');
$result = $query->result();
foreach($result as $row){
	$route[$row->page_url]="sitemanager/showPage";
}*/
/* $sql="SELECT p1.page_url as childUrl, p2.page_url as parentUrl from pages p1 LEFT OUTER JOIN pages p2 ON p1.parent_id=p2.page_id where p1.parent_id >0";
$res=$db->query($sql);
$result=$res->result();
foreach($result as $row){
	$route[$row->parentUrl . '/' . $row->childUrl]="sitemanager/showSubPage";
} */


$route['blog']='sitemanager/blogList';
$route['contact-us'] = 'sitemanager/contact';
$route['save-contact'] = 'sitemanager/saveContact';
$route['save-contact-from'] = 'sitemanager/saveContactForm';
$route['save-contact-gen'] = 'sitemanager/saveContactwithoutCaptcha';
$route['save-subs'] = 'sitemanager/saveSubscription';
$route['thank-you'] = 'sitemanager/thank_you';
$route['career'] = 'sitemanager/career';
$route['request-a-quote']='sitemanager/request_a_quote';
$route['send-request']='sitemanager/send_request';

/*================ Admin routing =====================*/


$route['admin']='adminmanager/index';
$route['admin-dashboard']='adminmanager/dashboard';
$route['do-login']='adminmanager/doLogin';
$route['log-out']='adminmanager/logout';
$route['admin/add-post-other-images/(:num)']='blogmanager/addOtherImages/$1';
$route['admin/add-post-video-links/(:num)']='blogmanager/addVideoLinks/$1';

/*************************** USERS ***************************/
$route['admin/list-user']='adminmanager/userList';
$route['admin/add-user']='adminmanager/addUser';
$route['admin/update-user/(:any)']='adminmanager/updateUser/$1';
$route['admin/delete-user/(:any)']='adminmanager/deleteUser/$1';
$route['admin/change-user-status/(:any)']='adminmanager/changeUserStatus/$1';
$route['admin/delete-or-ac_inac-multi-user']='adminmanager/delete_or_ac_inac_multi_user';
$route['admin/change-password']='adminmanager/userChangePassword';

/********************* SERVICE CATEGORY***************************/
$route['admin/service-parent-category-list-by-id']='servicemanager/getParentCategoryIdList';
$route['admin/service-category']='servicemanager/index';
$route['admin/add-service-category']='servicemanager/addServiceCategory';
$route['admin/save-service-category']='servicemanager/saveServiceCategory';
$route['admin/change-service-category-status/(:any)']='servicemanager/changeServiceCategoryStatus/$1';
$route['admin/edit-service-category/(:any)']='servicemanager/editServiceCategory/$1';
$route['admin/update-service-category/(:any)']='servicemanager/updateServiceCategory/$1';
$route['admin/delete-service-category/(:any)']='servicemanager/deleteServiceCategory/$1';
$route['admin/delete-or-ac_inac-multi-sub-cat']='servicemanager/delete_or_ac_inac_multi_sub_cat';
$route['admin/delete-or-ac_inac-multi-cat']='servicemanager/delete_or_ac_inac_multi_cat';

/********************* SERVICE ***************************/
$route['admin/add-service']='servicemanager/addService';
$route['admin/add-service/(:any)']='servicemanager/addService/$1';
$route['admin/list-service']='servicemanager/serviceList';
$route['admin/list-service/(:num)']='servicemanager/serviceList/$1';
$route['admin/list-service-trash']='servicemanager/serviceListTrash';
$route['admin/change-service-status/(:any)']='servicemanager/change_service_status/$1';
$route['admin/delete-or-ac_inac-multi-service']='servicemanager/delete_or_ac_inac_multi_service';
$route['admin/trash-service/(:any)']='servicemanager/trashService/$1';
$route['admin/delete-service/(:any)']='servicemanager/deleteService/$1';
$route['admin/restore-service/(:any)']='servicemanager/restoreService/$1';
$route['admin/update-service/(:num)']='servicemanager/updateService/$1';

/*************************** PACKAGE ***************************/
$route['admin/add-package']='servicemanager/addPackage';
$route['admin/add-package/(:any)']='servicemanager/addPackage/$1';
$route['admin/list-package']='servicemanager/packageList';
$route['admin/list-package/(:num)']='servicemanager/packageList/$1';
$route['admin/change-package-status/(:any)']='servicemanager/change_package_status/$1';
$route['admin/delete-or-ac_inac-multi-package']='servicemanager/delete_or_ac_inac_multi_package';
$route['admin/delete-package/(:any)']='servicemanager/deletePackage/$1';
$route['admin/update-package/(:num)']='servicemanager/updatePackage/$1';

/*************************** PACKAGE ENTITY ***************************/
$route['admin/add-package-entity']='servicemanager/addPackageEntity';
$route['admin/add-package-entity/(:any)']='servicemanager/addPackageEntity/$1';
$route['admin/list-package-entity']='servicemanager/packageEntityList';
$route['admin/list-package-entity/(:num)']='servicemanager/packageEntityList/$1';
$route['admin/change-package-entity-status/(:any)']='servicemanager/change_package_entity_status/$1';
$route['admin/delete-or-ac_inac-multi-package-entity']='servicemanager/delete_or_ac_inac_multi_package_entity';
$route['admin/delete-package-entity/(:any)']='servicemanager/deletePackageEntity/$1';
$route['admin/update-package-entity/(:num)']='servicemanager/updatePackageEntity/$1';

/************************** PACKAGE ENTITY VALUE ***********************/
$route['admin/add-package-entity-value']='servicemanager/addPackageEntityValue';
$route['admin/add-package-entity-value/(:any)']='servicemanager/addPackageEntityValue/$1';
$route['admin/list-package-entity-value']='servicemanager/packageEntityValueList';
$route['admin/list-package-entity-value/(:num)']='servicemanager/packageEntityValueList/$1';
$route['admin/change-package-entity-value-status/(:any)']='servicemanager/change_package_entity_value_status/$1';
$route['admin/delete-or-ac_inac-multi-package-entity-value']='servicemanager/delete_or_ac_inac_multi_package_entity_value';
$route['admin/delete-package-entity-value/(:any)']='servicemanager/deletePackageEntityValue/$1';
$route['admin/update-package-entity-value/(:num)']='servicemanager/updatePackageEntityValue/$1';

/***************** MASTER COUNTRY ********************/
$route['admin/add-country']='servicemanager/addCountry';
$route['admin/add-country/(:any)']='servicemanager/addCountry/$1';
$route['admin/list-country']='servicemanager/countryList';
$route['admin/list-country/(:num)']='servicemanager/countryList/$1';
$route['admin/change-country-status/(:any)']='servicemanager/change_country_status/$1';
$route['admin/delete-or-ac_inac-multi-country']='servicemanager/delete_or_ac_inac_multi_country';
$route['admin/delete-country/(:any)']='servicemanager/deleteCountry/$1';
$route['admin/update-country/(:num)']='servicemanager/updateCountry/$1';

/***************** MASTER LOCATION ********************/
$route['admin/add-location']='servicemanager/addLocation';
$route['admin/add-location/(:any)']='servicemanager/addLocation/$1';
$route['admin/list-location']='servicemanager/locationList';
$route['admin/list-location/(:num)']='servicemanager/locationList/$1';
$route['admin/change-location-status/(:any)']='servicemanager/change_location_status/$1';
$route['admin/delete-or-ac_inac-multi-location']='servicemanager/delete_or_ac_inac_multi_location';
$route['admin/delete-location/(:any)']='servicemanager/deleteLocation/$1';
$route['admin/update-location/(:num)']='servicemanager/updateLocation/$1';

/***************** MASTER STATE ********************/
$route['admin/add-state']='servicemanager/addState';
$route['admin/add-state/(:any)']='servicemanager/addState/$1';
$route['admin/list-state']='servicemanager/stateList';
$route['admin/list-state/(:num)']='servicemanager/stateList/$1';
$route['admin/change-state-status/(:any)']='servicemanager/change_state_status/$1';
$route['admin/delete-or-ac_inac-multi-state']='servicemanager/delete_or_ac_inac_multi_state';
$route['admin/delete-state/(:any)']='servicemanager/deleteState/$1';
$route['admin/update-state/(:num)']='servicemanager/updateState/$1';

/***************** ORDER ********************/
//$route['admin/add-state']='servicemanager/addState';
//$route['admin/add-state/(:any)']='servicemanager/addState/$1';
$route['admin/list-order']='servicemanager/orderList';
$route['admin/list-order/(:num)']='servicemanager/orderList/$1';
$route['admin/change-order-status/(:any)']='servicemanager/change_order_status/$1';
$route['admin/delete-or-ac_inac-multi-order']='servicemanager/delete_or_ac_inac_multi_order';
$route['admin/delete-order/(:any)']='servicemanager/deleteOrder/$1';
$route['admin/update-order/(:num)']='servicemanager/updateOrder/$1';

/***************** ORDER DETAILS ********************/
$route['admin/add-order-details']='servicemanager/addOrderDetails';
$route['admin/add-order-details/(:any)']='servicemanager/addOrderDetails/$1';
$route['admin/list-order-details']='servicemanager/orderDetailsList';
$route['admin/list-order-details/(:num)']='servicemanager/orderDetailsList/$1';
$route['admin/change-order-details-status/(:any)']='servicemanager/change_orderdetails_status/$1';
$route['admin/delete-or-ac_inac-multi-order-details']='servicemanager/delete_or_ac_inac_multi_orderdetails';
$route['admin/delete-order-details/(:any)']='servicemanager/deleteOrderDetails/$1';
$route['admin/update-order-details/(:num)']='servicemanager/updateOrderDetails/$1';

/***************** CUSTOMER ADDRESS ********************/
$route['admin/add-customer-address']='servicemanager/addCustomerAddress';
$route['admin/add-customer-address/(:any)']='servicemanager/addCustomerAddress/$1';
$route['admin/list-customer-address']='servicemanager/customerAddressList';
$route['admin/list-customer-address/(:num)']='servicemanager/orderDetailsList/$1';
$route['admin/change-customer-address-status/(:any)']='servicemanager/change_customeraddress_status/$1';
$route['admin/delete-or-ac_inac-multi-customer-address']='servicemanager/delete_or_ac_inac_multi_customeraddress';
$route['admin/delete-customer-address/(:any)']='servicemanager/deleteCustomerAddress/$1';
$route['admin/update-customer-address/(:num)']='servicemanager/updateCustomerAddress/$1';


/*************************** SETTINGS ***************************/
$route['admin/add-gallery']='settingsmanager/addGallery';
$route['admin/add-gallery/(:any)']='settingsmanager/addGallery/$1';
$route['admin/list-gallery']='settingsmanager/galleryList';
$route['admin/list-gallery/(:num)']='settingsmanager/galleryList/$1';
$route['admin/change-gallery-status/(:any)']='settingsmanager/change_gallery_status/$1';
$route['admin/delete-or-ac_inac-multi-gallery']='settingsmanager/delete_or_ac_inac_multi_gallery';
$route['admin/delete-gallery/(:any)']='settingsmanager/deleteGallery/$1';
$route['admin/update-gallery/(:num)']='settingsmanager/updateGallery/$1';

/************ MAIL *************/
$route['admin/mail-config']='settingsmanager/mail';

/*************** MAIL TEMPLATES ******************************/
$route['admin/list-template']='settingsmanager/templatesList';
$route['admin/add-template']='settingsmanager/addTemplate';
$route['admin/update-template/(:num)']='settingsmanager/updateTemplate/$1';
$route['admin/change-template-status/(:any)']='settingsmanager/changeTemplateStatus/$1';
$route['admin/delete-template/(:any)']='settingsmanager/deleteTemplate/$1';
$route['admin/delete-or-ac_inac-multi-template']='settingsmanager/delete_or_ac_inac_multi_template';



$route['admin/images']='adminmanager/imagelist';
$route['admin/contacts']='adminmanager/contacts';
$route['admin/delete-contact/(:num)']='adminmanager/contact_delete/$1';
$route['admin/delete-uploaded-image/(:any)']='adminmanager/delete_uploaded_image/$1';
$route['admin/tracks']='adminmanager/tracklist';
$route['admin/delete-tracker/(:any)']='adminmanager/trackdelete/$1';

//dynamic home page 
$route['admin/videos']='adminmanager/videolist';
$route['admin/delete-videos/(:any)']='adminmanager/delete_uploaded_video/$1';
$route['admin/home-about-content-add']='adminmanager/addHomeAboutContent';
$route['admin/save-home-about-content']='adminmanager/saveHomeAboutContent';
$route['admin/home-about-content-list']='adminmanager/homeAboutContentList';
$route['admin/edit-home-about-content/(:any)']='adminmanager/editHomeAboutContent/$1';
$route['admin/update-home-about-content/(:any)']='adminmanager/updateHomeAboutContent/$1';
$route['admin/delete-home-about-content/(:any)']='adminmanager/deleteHomeAboutContent/$1';


//$route['blog/(:any)']='sitemanager/blogListByCategory/$1';
//$route['blog/(:any)/(:any)']='sitemanager/blogDetails';
$route['blog/(:any)']='sitemanager/blogDetails/$1';
$route['(:any)']='sitemanager/showPage';


/************************ FOR API ROUTES  **********************************/

/** Users */
$route['api/users'] = 'api/userList';
$route['api/userregister'] = 'api/userRegister';
$route['api/userlogin'] = 'api/userLogin';
$route['api/userprofile/(:num)'] = 'api/userProfile/$1';
$route['api/userprofileupdate/(:num)'] = 'api/userProfileUpdate/$1';

$route['api/userforgetpasswordotp'] = 'api/userForgetPasswordOtp';
$route['api/userforgetpasswordupdate'] = 'api/userForgetPasswordUpdate';

/** category and subcategory **/
$route['api/recentcategorylist'] = 'api/recentCategoryList';
$route['api/categorylist'] = 'api/categoryList';
$route['api/categorylistbyname'] = 'api/categoryList';
$route['api/categoryid/(:any)'] = 'api/categoryId/$1';
$route['api/subcategorylist/(:num)/(:num)'] = 'api/subcategoryList/$1/$2';

/** Services **/
$route['api/serviceslistbycatid/(:num)'] = 'api/servicesListByCatId/$1';
$route['api/serviceslistbysubcatid/(:num)'] = 'api/servicesListBySubCatId/$1';
$route['api/recentserviceslist'] = 'api/recentServicesList';

/** Packages and packages entity **/
$route['api/packageslistbyserviceid/(:num)'] = 'api/packagesListByServiceId/$1';
$route['api/packagesdetails/(:num)'] = 'api/packagesDetails/$1';

/** Locations **/
$route['api/locationlist'] = 'api/locationList';
$route['api/locationid/(:any)'] = 'api/locationId/$1';

/** States **/
$route['api/statelist'] = 'api/stateList';

/** Orders **/
$route['api/orderlistbycustid/(:any)'] = 'api/orderListByCustomerId/$1';
$route['api/orderdetailsbyid/(:any)'] = 'api/orderDetailsByID/$1';
$route['api/orderconfig'] = 'api/orderConfig';
$route['api/addorder'] = 'api/addOrder';
$route['admin/updateorderbypaytm'] = 'servicemanager/updateOrderByPaytm';

/** Customers **/
$route['api/cusaddlistbycusid/(:num)'] = 'api/customerAddressListByCusId/$1';
$route['api/addcustomeraddress'] = 'api/addCustomerAddress';

/** Gallery **/
$route['api/galleryimagelist'] = 'api/galleryImageList';

/** CONTACT US **/
$route['api/contactusmail'] = 'api/contactUsMail';

/** PACKAGE RATING **/
$route['api/addpackagerating'] = 'api/addPackageRating';

/** Slug Check */
$route['api/checkslug/(:any)'] = 'api/checkSlug/$1';

/************************ FOR API ROUTES  **********************************/

$route['threadcheck'] = 'admin/';