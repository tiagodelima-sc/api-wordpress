<?php

function user_post($request)
{
  $nome = $request['nome'];
  $email = sanitize_email($request['email']);
  $senha = $request['senha'];
  $rua = sanitize_text_field($request['rua']);
  $bairro = sanitize_text_field($request['bairro']);
  $cidade = sanitize_text_field($request['cidade']);
  $numero = sanitize_text_field($request['numero']);
  $cep = sanitize_text_field($request['cep']);
  $estado = sanitize_text_field($request['estado']);

  $user_exists = username_exists($email);
  $email_exist = email_exists($email);

  if(!$user_exists && !$email_exist && $email && $senha){
    $user_id = wp_create_user($email, $senha, $email);

    $response = [
      'ID' => $user_id,
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
    $response = new WP_Error('email', 'Usuário já cadastrado.' , ['status' => 403]);
  }

  return rest_ensure_response($response);
}

function register_user_post()
{
  register_rest_route('api/v1', 'user', [
    [
      'methods' => WP_REST_Server::CREATABLE,
      'callback' => 'user_post',

    ],
  ]);
}

add_action('rest_api_init', 'register_user_post');
