<?php

function user_put($request)
{

    $user = wp_get_current_user();
    $user_id = $user->ID;

    if ($user_id > 0) {

        $nome = $request['nome'];
        $email = sanitize_email($request['email']);
        $senha = $request['senha'];
        $rua = sanitize_text_field($request['rua']);
        $bairro = sanitize_text_field($request['bairro']);
        $cidade = sanitize_text_field($request['cidade']);
        $numero = sanitize_text_field($request['numero']);
        $cep = sanitize_text_field($request['cep']);
        $estado = sanitize_text_field($request['estado']);

        $email_exist = email_exists($email);

        if (!$email_exist || $email_exist === $user_id) {

            $response = [
                'ID' => $user_id,
                'user_email' => $email,
                'user_pass' => $senha,
                'display_name' => $nome,
                'role' => 'subscriber'
            ];

            wp_update_user($response);

            update_user_meta($user_id, 'rua', $rua);
            update_user_meta($user_id, 'bairro', $bairro);
            update_user_meta($user_id, 'cidade', $cidade);
            update_user_meta($user_id, 'numero', $numero);
            update_user_meta($user_id, 'cep', $cep);
            update_user_meta($user_id, 'estado', $estado);


        } else {
            $response = new WP_Error('email', 'Usuário já cadastrado.', ['status' => 403]);
        }
    } else {
        $response = new WP_Error('permissao', 'Usuário não possui permissão.', ['status' => 401]);
    }
    return rest_ensure_response($response);
}

function register_user_put()
{
    register_rest_route('api/v1', 'user', [
        [
            'methods' => WP_REST_Server::EDITABLE,
            'callback' => 'user_put',

        ],
    ]);
}

add_action('rest_api_init', 'register_user_put');