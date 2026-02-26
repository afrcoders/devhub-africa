@extends('errors.layout')

@section('code', $exception->getStatusCode())
@section('icon', '❌')
@section('title', 'Error')

@section('message', 'An error occurred while processing your request.')

@section('description', 'We\'re sorry, but something didn\'t work as expected. Please try again or contact our support team if the problem persists.')
