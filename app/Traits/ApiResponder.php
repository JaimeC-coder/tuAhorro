<?php

namespace App\Traits;


use Closure;
use App\Http\Response\JsonResponse;
use App\Http\Response\ApiValidationException;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

use Illuminate\Support\Facades\Log;

trait ApiResponder
{
    public function handleApiRequest(Closure $callback, string $successMessage, int $statusCode = 200)
    {
        try {
            $data = $callback();
            return JsonResponse::success($data, $successMessage, true, 1, $statusCode);
        } catch (ApiValidationException $e) {
            return JsonResponse::error($e->render(), $e->getMessage(), false, 0, $e->getCode() ?: 422);
        } catch (UnauthorizedHttpException $e) {
            return JsonResponse::error(null, $e->getMessage(), false, 0, 401);
        } catch (ValidationException  $th) {
            return JsonResponse::error($th->errors(), 'Error de validación', false, 0, 422);
        } catch (HttpResponseException $e) {
            return JsonResponse::error(null, $e->getMessage(), false, 0, $e->getResponse()->getStatusCode() ?? 400);
        } catch (QueryException $e) {
            Log::error('QueryException en API: ', [
                'message' => $e->getMessage(),
                'sql'     => $e->getSql(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return JsonResponse::error(
                null,'Error en la base de datos',false,0,500
            );
        } catch (\Throwable $e) {
            Log::error('Error inesperado en API: ', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
            return JsonResponse::error(app()->isLocal() ? $e->getMessage() : null, 'Ocurrió un error inesperado',false,0,500);
        }
    }

    protected function handle(Closure $callback)
    {
        try {
            return $callback();
        } catch (QueryException $e) {
            Log::error('------------Error Base de datos-----------------------------');
            Log::error('Error en la consulta: ' . $e->getMessage());
            Log::error('Código de error: ' . $e->getCode() . 'Archivo: ' . $e->getFile() . ' en la línea ' . $e->getLine());
            Log::error('Consulta SQL: ' . $e->getSql());
            Log::error('--------------------------------------------------------------');
            throw new Exception('Error en la base de datos: ' . $e->getMessage(), 400);
        } catch (\Throwable $th) {
            Log::error('------------Error Inesperado-----------------------------');
            Log::error('Error inesperado: ' . $th->getMessage());
            Log::error('--------------------------------------------------------------');
            throw new Exception('Error inesperado: ' . $th->getMessage(), 500);
        }
    }
}
