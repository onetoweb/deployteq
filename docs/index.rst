.. title:: Index

Index
=====

.. contents::
    :local:

===========
Basic Usage
===========

Setup

.. code-block:: php
    
    require 'vendor/autoload.php';
    
    use Onetoweb\Deployteq\Client;
    
    // param
    $token = 'token';
    $endpoint = '42-foobar';
    
    // setup client
    $client = new Client($token, $endpoint);


========
Examples
========

* `Datamodel <datamodel.rst>`_