<?php

namespace App\Traits;


use Closure;
use App\Http\Response\JsonResponse;
use App\Http\Response\ApiValidationException;
use Exception;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

trait ApiResponder
{
    public function handleApiRequest(Closure $callback, string $successMessage, int $statusCode = 200)
    {
        try {
            $data = $callback();
            return JsonResponse::success($data, $successMessage, true, 1, $statusCode);
        } catch (ApiValidationException $e) {
            return JsonResponse::error($e->render(), $e->getMessage(), false, 0, $e->getCode());
        }catch (UnauthorizedHttpException $e) {
            return JsonResponse::error(null, $e->getMessage(), false, 0, 401);
        } catch (\Exception $e) {
            return JsonResponse::error($e->getMessage(), 'Ocurrió un error', false, 0, 500);
        }
    }

    protected function handle(Closure $callback)
    {
        try {
            return $callback();
        } catch (QueryException $e) {
            throw new Exception('Error en la base de datos: ' . $e->getMessage(), 400);
        } catch (\Throwable $th) {
            throw new Exception('Error inesperado: ' . $th->getMessage(), 500);
        }
    }
}
