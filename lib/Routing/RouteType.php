<?php

namespace Therion86\Framework\Routing;

enum RouteType
{
    case GET;
    case POST;
    case PUT;
    case DELETE;
    case PATCH;

    case CLI;
}
