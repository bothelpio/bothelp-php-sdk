<?php

namespace BothelpSDK\Config;

class Endpoints
{
    public const ALLOWED_METHODS = ['POST', 'GET', 'PUT', 'PATCH', 'DELETE'];
    public const AUTH_URL = 'https://oauth.bothelp.io/oauth2/token';
    public const BASE_API_URL = 'https://api.bothelp.io';
    public const V1 = 'v1';
    public const SUBSCRIBERS_RESOURCE = 'subscribers';
    public const CUID_RESOURCE = 'cuid';
    public const CUSTOMER_FIELDS_RESOURCE = 'customFields';
    public const MESSAGES_RESOURCE = 'messages';
}
