<?php

$template_default = get_template_directory();

require_once($template_default . '/custom-post-type/product.php');
require_once($template_default . '/custom-post-type/transaction.php');


require_once($template_default . '/endpoints/user_post.php');
require_once($template_default . '/endpoints/user_get.php');
require_once($template_default . '/endpoints/user_put.php');


function expire_toke_jwt(){
    return time() + (120 * 24);
}

add_action('jwt_auth_expire','expire_toke_jwt');


?>
