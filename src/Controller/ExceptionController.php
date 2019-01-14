<?php
    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpKernel\Tests\Controller;
    use Symfony\Component\Routing\Annotation\Route;

    use Symfony\Component\Debug\Exception\FlattenException;
    use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
    use Twig\Environment;
    use Twig\Error\LoaderError;
    use Twig\Loader\ExistsLoaderInterface;




    class ExceptionController extends AbstractController
    {
        public function showException($exception, $logger)
        {
            $codeHTTP = $exception->getStatusCode();

            if ($codeHTTP !== null)
            {
                switch ($codeHTTP){
                    case 100: $textHTTP = 'Continue'; break;
                    case 101: $textHTTP = 'Switching Protocols'; break;
                    case 200: $textHTTP = 'OK'; break;
                    case 201: $textHTTP = 'Created'; break;
                    case 202: $textHTTP = 'Accepted'; break;
                    case 203: $textHTTP = 'Non-Authoritative Information'; break;
                    case 204: $textHTTP = 'No Content'; break;
                    case 205: $textHTTP = 'Reset Content'; break;
                    case 206: $textHTTP = 'Partial Content'; break;
                    case 300: $textHTTP = 'Multiple Choices'; break;
                    case 301: $textHTTP = 'Moved Permanently'; break;
                    case 302: $textHTTP = 'Moved Temporarily'; break;
                    case 303: $textHTTP = 'See Other'; break;
                    case 304: $textHTTP = 'Not Modified'; break;
                    case 305: $textHTTP = 'Use Proxy'; break;
                    case 400: $textHTTP = 'Bad Request'; break;
                    case 401: $textHTTP = 'Unauthorized'; break;
                    case 402: $textHTTP = 'Payment Required'; break;
                    case 403: $textHTTP = 'Forbidden'; break;
                    case 404: $textHTTP = 'Not Found'; break;
                    case 405: $textHTTP = 'Method Not Allowed'; break;
                    case 406: $textHTTP = 'Not Acceptable'; break;
                    case 407: $textHTTP = 'Proxy Authentication Required'; break;
                    case 408: $textHTTP = 'Request Time-out'; break;
                    case 409: $textHTTP = 'Conflict'; break;
                    case 410: $textHTTP = 'Gone'; break;
                    case 411: $textHTTP = 'Length Required'; break;
                    case 412: $textHTTP = 'Precondition Failed'; break;
                    case 413: $textHTTP = 'Request Entity Too Large'; break;
                    case 414: $textHTTP = 'Request-URI Too Large'; break;
                    case 415: $textHTTP = 'Unsupported Media Type'; break;
                    case 500: $textHTTP = 'Internal Server Error'; break;
                    case 501: $textHTTP = 'Not Implemented'; break;
                    case 502: $textHTTP = 'Bad Gateway'; break;
                    case 503: $textHTTP = 'Service Unavailable'; break;
                    case 504: $textHTTP = 'Gateway Time-out'; break;
                    case 505: $textHTTP = 'HTTP Version not supported'; break;
                    default: $textHTTP  = 'Unknown HTTP code';break;
                }
            }
            return $this->render('bundles/TwigBundle/Exception/error.html.twig', array(
                'codeHTTP' => $codeHTTP,
                'textHTTP' => $textHTTP
            ));
        }

    }