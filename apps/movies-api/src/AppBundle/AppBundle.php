<?php

namespace ApiCycle\ApiMovies\AppBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @SWG\Swagger(
 *   @SWG\Info(
 *     title="Movies API",
 *     version="1.0"
 *   ),
 *   schemes={"http"},
 *   basePath="/v1"
 * )
 */
class AppBundle extends Bundle
{
}
