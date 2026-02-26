@extends('errors.layout')

@section('code', '429')
@section('icon', '⚡')
@section('title', 'Too Many Requests')

@section('message', 'You\'ve made too many requests. Please slow down.')

@section('description', 'We\'ve detected multiple rapid requests from your account. Please wait a moment before trying again. This is a security measure to protect your account.')
