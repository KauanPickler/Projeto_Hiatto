<?php

namespace App\Services\Magazord;

use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MagazordService
{
    public PendingRequest $api;

    public function __construct()
    {
        $this->api = Http::withBasicAuth(
            config('services.magazord.token'),
            config('services.magazord.password')
        )
            ->acceptJson()
            ->baseUrl(config('services.magazord.base_url'));
    }
    //////Buscar Marcas//////
    public function getBrands(int $page = 1): Collection|Response
    {
        try {
            $response = $this->api->get('/site/marca', ['page' => $page]);
            return collect($response->json());
        } catch (Exception $e) {
            Log::error('Error fetching brands from Magazord', ['error' => $e->getMessage()]);
            return $this->errorResponse('Erro ao buscar marcas: ' . $e->getMessage());
        }
    }

    //////Buscar Unidade de Medida//////
    public function getUnitsOfMeasurement(): Collection|Response
    {
        try {
            $response = $this->api->get('/site/unidadeMedida');
            return collect($response->json());
        } catch (Exception $e) {
            Log::error('Error fetching brands from Magazord', ['error' => $e->getMessage()]);
            return $this->errorResponse('Erro ao buscar unidade Medida: ' . $e->getMessage());
        }
    }

    //////Buscar Derivação//////
    public function getDerivation(): Collection|Response
    {
        try {
            $response = $this->api->get('/site/derivacao');
            return collect($response->json());
        } catch (Exception $e) {
            Log::error('Error fetching brands from Magazord', ['error' => $e->getMessage()]);
            return $this->errorResponse('Erro ao buscar unidade Medida: ' . $e->getMessage());
        }
    }

    //////Buscar Derivação por ID//////
    public function getDerivationOptions($derivationTypeId, $page = 1): Collection|Response
    {
        try {
            $response = $this->api->get('/site/derivacao/{$derivationTypeId}/item', ['page' => $page]);
            return collect($response->json());
        } catch (Exception $e) {
            Log::error('Error fetching brands from Magazord', ['error' => $e->getMessage()]);
            return $this->errorResponse('Erro ao buscar unidade Medida: ' . $e->getMessage());
        }
    }
    //////Buscar Produtos//////
    public function getProdutos(array $filtros = []): Collection|Response
    {
        try {
            $query = [
                'limit' => $filtros['limit'] ?? 10,
                'page' => $filtros['page'] ?? 1,
                'order' => $filtros['order'] ?? null,
                'orderDirection' => $filtros['orderDirection'] ?? null,
                'ean' => $filtros['ean'] ?? null,
                'categoria' => $filtros['category'] ?? null,
                'marca' => $filtros['brand'] ?? null,
                'nome' => $filtros['name'] ?? null,
                'codigo' => $filtros['code'] ?? null,
                'loja' => $filtros['store'] ?? null,
                'dataLancamento' => $filtros['releaseDate'] ?? null,
            ];
            $query = array_filter($query, fn($value) => !is_null($value));
    
            $response = $this->api->get('/site/produto', $query);
    
            return collect($response->json());
        } catch (Exception $e) {
            Log::error('Erro ao buscar produtos na Magazord', ['error' => $e->getMessage()]);
            return $this->errorResponse('Erro ao buscar produtos: ' . $e->getMessage());
        }
    }
    

    //////Buscar Lojas//////
    public function getStores(int $page = 1): Collection|Response
    {
        try {
            $response = $this->api->get('/site/loja', ['page' => $page]);
            return collect($response->json());
        } catch (Exception $e) {
            Log::error('Error fetching stores from Magazord', ['error' => $e->getMessage()]);
            return $this->errorResponse('Erro ao buscar lojas: ' . $e->getMessage());
        }
    }

    //////Buscar Categorias//////
    public function getCategories(int $page = 1): Collection|Response
    {
        try {
            $response = $this->api->get('/site/categoria', ['page' => $page]);
            return collect($response->json());
        } catch (Exception $e) {
            Log::error('Error fetching stores from Magazord', ['error' => $e->getMessage()]);
            return $this->errorResponse('Erro ao buscar Categoria: ' . $e->getMessage());
        }
    }

    //////Buscar Caracteristicas//////
    public function getCharacteristics(int $page = 1): Collection|Response
    {
        try {
            $response = $this->api->get('/site/caracteristica', ['page' => $page]);
            return collect($response->json());
        } catch (Exception $e) {
            Log::error('Error fetching stores from Magazord', ['error' => $e->getMessage()]);
            return $this->errorResponse('Erro ao buscar Caracteristicas: ' . $e->getMessage());
        }
    }

    //////Buscar NCM//////
    public function getNCM(int $page = 1): Collection|Response
    {
        try {
            $response = $this->api->get('/site/ncm', ['page' => $page]);
            return collect($response->json());
        } catch (Exception $e) {
            Log::error('Error fetching stores from Magazord', ['error' => $e->getMessage()]);
            return $this->errorResponse('Erro ao buscar NCM: ' . $e->getMessage());
        }
    }

    //////Buscar CEST//////
    public function getCEST(int $page = 1): Collection|Response
    {
        try {
            $response = $this->api->get('/site/cest', ['page' => $page]);
            return collect($response->json());
        } catch (Exception $e) {
            Log::error('Error fetching stores from Magazord', ['error' => $e->getMessage()]);
            return $this->errorResponse('Erro ao buscar CEST: ' . $e->getMessage());
        }
    }

    //////Buscar PIS//////
    public function getPIS(int $page = 1): Collection|Response
    {
        try {
            $response = $this->api->get('/faturamento/situacao-tributaria', ['page' => $page, 'tipo' => 2]);
            return collect($response->json());
        } catch (Exception $e) {
            Log::error('Error fetching stores from Magazord', ['error' => $e->getMessage()]);
            return $this->errorResponse('Erro ao buscar PIS: ' . $e->getMessage());
        }
    }

    //////Buscar COFINS//////
    public function getCOFINS(int $page = 1): Collection|Response
    {
        try {
            $response = $this->api->get('/faturamento/situacao-tributaria', ['page' => $page, 'tipo' => 3]);
            return collect($response->json());
        } catch (Exception $e) {
            Log::error('Error fetching stores from Magazord', ['error' => $e->getMessage()]);
            return $this->errorResponse('Erro ao buscar COFINS: ' . $e->getMessage());
        }
    }
    //////Criar Produtos//////
    public function createProduct(array $data): Collection|Response
    {
        try {
            $payload = [
                'codigo' => $data['code'],
                'nome' => $data['name'],
                'marca' => $data['brand'],
                'peso' => $data['weight'],
                'unidadeMedida' => $data['unitOfMeasurement'],
                'origemFiscal' => $data['taxOrigin'],
                'derivacoes' => $data['derivations'],
                'categorias' => $data['categories'],
                'ncm' => $data['ncm'],
                'cest' => $data['cest'] ?? null,
                'situacaoTributaria' => [],
                'produtoLoja' => collect($data['stores'])->map(fn($store) => ['loja' => $store])->toArray(),
                'dataLancamento' => $data['releaseDate'],
            ];

            if (!empty($data['pis'])) {
                $payload['situacaoTributaria'][] = ['tipo' => 2, 'codigo' => $data['pis']];
            }

            if (!empty($data['cofins'])) {
                $payload['situacaoTributaria'][] = ['tipo' => 3, 'codigo' => $data['cofins']];
            }

            $response = $this->api->post('/site/produto', $payload);
            return collect($response->json());
        } catch (Exception $e) {
            Log::error('Error creating product in Magazord', ['error' => $e->getMessage()]);
            return $this->errorResponse('Erro ao criar produto: ' . $e->getMessage());
        }
    }

    private function errorResponse(string $message): Collection
    {
        return collect([
            'error' => true,
            'message' => $message,
        ]);
    }
}
