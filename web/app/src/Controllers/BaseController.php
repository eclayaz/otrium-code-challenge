<?php

namespace App\Controllers;

abstract class BaseController
{
  /**
   * @param string $message
   * @param array $errors
   */
  protected function failResponse(string $message, array $errors = []): void
  {
    $data['success'] = false;
    $data['message'] = $message;
    $data['errors'] = $errors;
    echo json_encode($data);
  }


  /**
   * @param $responseData
   */
  protected function successResponse($responseData): void
  {
    $data['success'] = true;
    $data['message'] = 'Success!';
    $data['errors'] = [];
    $data['responseData'] = $responseData;
    echo json_encode($data);
  }
}