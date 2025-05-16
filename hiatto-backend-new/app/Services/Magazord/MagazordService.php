<?php

namespace App\Services\Magazord;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
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
            return $this->errorResponse('Erro ao buscar derivações: ' . $e->getMessage());
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



    //////Listar Produtos//////
    public function getOneProduct(Request $request): Collection|Response|JsonResponse
{
    try {
        $code = $request->query('code');
        $response = $this->api->get("/site/produto/{$code}");

        return collect($response->json());
    } catch (Exception $e) {
        Log::error('Error fetching product from Magazord', ['error' => $e->getMessage()]);
        return $this->errorResponse('Erro ao buscar produto: ' . $e->getMessage());
    }
}



    //////Adicionar Caracteristicas//////
    public function addCharacteristics(string $productCode, string $genre, array $collections, array $combos): Collection|Response
{
    try {
        $payload = [
            'caracteristicas' => [
                [
                    'caracteristica' => 2,
                    'valor' => $genre,
                ],
                [
                    'caracteristica' => 18,
                    'valor' => $collections,
                ],
                [
                    'caracteristica' => 17,
                    'valor' => $combos,
                ],
            ],
        ];

        $response = $this->api->post("/site/produto/{$productCode}/caracteristica", $payload);

        return collect($response->json());
    } catch (Exception $e) {
        Log::error('Erro ao adicionar características ao produto na Magazord', ['error' => $e->getMessage()]);
        return $this->errorResponse('Erro ao adicionar características: ' . $e->getMessage());
    }
}



    //////Produto por preço//////
    public function getProductPrices(Request $request, int $priceTable = 1): Collection|Response
{
    try {
        $params = [
            'tabelaPreco' => $priceTable,
            'produto' => $request->query('code'),
        ];

        $response = $this->api->get('/listPreco', $params);

        $data = $response->json('data') ?? $response->json();

        return collect($data);
    } catch (Exception $e) {
        Log::error('Erro ao buscar preços do produto na Magazord', ['error' => $e->getMessage()]);
        return $this->errorResponse('Erro ao buscar preços do produto: ' . $e->getMessage());
    }
}


    //////Criar derivação de produto//////
    public function createProductDerivation(
        string $productCode,
        string $codeDerivation,
        string $name,
        array $derivations,
        array $stores
    ): Collection|Response {
        try {
            $payload = [
                'codigo' => $codeDerivation,
                'nome' => $name,
                'derivacoes' => collect($derivations)->map(function ($item) {
                    return [
                        'derivacao' => $item['id'],
                        'valor' => $item['value'],
                    ];
                })->toArray(),
                'lojas' => $stores,
            ];
    
            $response = $this->api->post("/site/produto/{$productCode}/derivacao", $payload);
    
            return collect($response->json());
        } catch (Exception $e) {
            Log::error('Erro ao criar derivação do produto na Magazord', ['error' => $e->getMessage()]);
            return $this->errorResponse('Erro ao criar derivação: ' . $e->getMessage());
        }
    }



    //////Ver todos os produtos de uma derivação//////
    public function findAllProductsXDerivations(array $filters = []): Collection|Response
{
    try {
        $query = [
            'limit' => $filters['limit'] ?? 10,
            'page' => $filters['page'] ?? 1,
            'order' => $filters['order'] ?? null,
            'orderDirection' => $filters['orderDirection'] ?? null,
            'tipoProduto' => $filters['productType'] ?? null,
            'codigo' => $filters['code'] ?? null,
            'nome' => $filters['name'] ?? null,
            'ativo' => $filters['active'] ?? null,
        ];

        // Remove campos nulos
        $query = array_filter($query, fn($value) => !is_null($value));

        $response = $this->api->get('/site/produtoDerivacoes', $query);

        return collect($response->json());
    } catch (Exception $e) {
        Log::error('Erro ao buscar produtos com derivações da Magazord', ['error' => $e->getMessage()]);
        return $this->errorResponse('Erro ao buscar produtos com derivações: ' . $e->getMessage());
    }
}



    //////ver as variantes de um produto//////
    public function findAllProductDerivations(string $code, int $limit = 10, int $page = 1): Collection|Response
{
    try {
        $query = [
            'limit' => $limit,
            'page' => $page,
        ];

        $response = $this->api->get("/site/produto/{$code}/derivacao", $query);

        return collect($response->json());
    } catch (Exception $e) {
        Log::error('Erro ao buscar derivações do produto na Magazord', [
            'code' => $code,
            'error' => $e->getMessage(),
        ]);

        return $this->errorResponse('Erro ao buscar derivações do produto: ' . $e->getMessage());
    }
}




    //////ver as variantes de um produto por code//////
    public function findOneProductDerivation(string $productCode, string $derivationCode): Collection|Response
{
    try {
        $response = $this->api->get("/site/produto/{$productCode}/derivacao/{$derivationCode}");

        return collect($response->json());
    } catch (Exception $e) {
        Log::error('Erro ao buscar derivação específica do produto na Magazord', [
            'product_code' => $productCode,
            'derivation_code' => $derivationCode,
            'error' => $e->getMessage(),
        ]);

        return $this->errorResponse('Erro ao buscar derivação do produto: ' . $e->getMessage());
    }
}



    //////Editar produto de uma derivação//////
    public function updateProductDerivation(
        string $productCode,
        string $derivationCode,
        string $name,
        array $derivations,
        array $stores,
        bool $active,
        ?string $alternativeCode = null
    ): Collection|Response
    {
        try {
            $payload = [
                'codigo' => $derivationCode,
                'nome' => $name,
                'derivacoes' => array_map(function ($derivation) {
                    return [
                        'derivacao' => $derivation['id'] ?? $derivation['derivation'] ?? null,
                        'valor' => $derivation['value'],
                    ];
                }, $derivations),
                'lojas' => $stores,
                'ativo' => $active,
                'codigoAlternativo' => $alternativeCode,
            ];
    
            // Remove null values (ex: 'codigoAlternativo' se for null)
            $payload = array_filter($payload, fn($value) => !is_null($value));
    
            $response = $this->api->put("/site/produto/{$productCode}/derivacao/{$derivationCode}", $payload);
    
            // Supondo que a resposta seja algo simples com mensagem de status
            return collect($response->json());
    
        } catch (Exception $e) {
            Log::error('Erro ao atualizar derivação do produto na Magazord', [
                'product_code' => $productCode,
                'derivation_code' => $derivationCode,
                'error' => $e->getMessage(),
            ]);
    
            return $this->errorResponse('Erro ao atualizar derivação do produto: ' . $e->getMessage());
        }
    }



    //////Deletar produto de uma derivação//////
    public function removeProductDerivation(string $productCode, string $derivationCode): bool
{
    try {
        $response = $this->api->delete("/site/produto/{$productCode}/derivacao/{$derivationCode}");

        // Supondo que o status 200 ou 204 indica sucesso na exclusão
        return $response->successful();
    } catch (Exception $e) {
        Log::error('Erro ao remover derivação do produto na Magazord', [
            'product_code' => $productCode,
            'derivation_code' => $derivationCode,
            'error' => $e->getMessage(),
        ]);

        return false;
    }
}



    //////Adicionar Preço//////
    public function addPrices(string $codeDerivation, float $oldPrice, float $salePrice): Collection
{
    $payload = [
        [
            'produto' => $codeDerivation,
            'tabelaPreco' => 1,
            'precoAntigo' => $oldPrice,
            'precoVenda' => $salePrice,
        ],
    ];

    try {
        $response = $this->api->post('/preco', $payload);

        return collect($response->json());
    } catch (Exception $e) {
        Log::error('Erro ao adicionar preços na Magazord', [
            'codeDerivation' => $codeDerivation,
            'oldPrice' => $oldPrice,
            'salePrice' => $salePrice,
            'error' => $e->getMessage(),
        ]);

        return $this->errorResponse('Erro ao adicionar preços: ' . $e->getMessage());
    }
}



    //////Ver depositos//////
    public function getDeposits(): Collection|Response
{
    try {
        $response = $this->api->get('/estoqueLocalizacao/deposito');
        return collect($response->json()['data'] ?? $response->json());
    } catch (Exception $e) {
        Log::error('Erro ao buscar depósitos na Magazord', ['error' => $e->getMessage()]);
        return $this->errorResponse('Erro ao buscar depósitos: ' . $e->getMessage());
    }
}



    //////Mover estoque//////
    public function moveStock(
        string $codeDerivation,
        int $deposit,
        int|float $amount,
        int $operationType, // 1 ou 2
        string $observation,
        float $moveValue
    ): Collection|Response
    {
        $payload = [
            'produto' => $codeDerivation,
            'deposito' => $deposit,
            'quantidade' => $amount,
            'tipo' => 1,
            'tipoOperacao' => $operationType,
            'origemMovimento' => $operationType === 1 ? 2 : 15,
            'observacao' => $observation,
            'valorMovimento' => $moveValue,
        ];
    
        try {
            $response = $this->api->post('/estoque', $payload);
    
            // Dependendo do retorno, adapte aqui.
            // Por exemplo, se MovementMade for uma entidade, faça a transformação.
            return collect($response->json());
        } catch (Exception $e) {
            Log::error('Erro ao movimentar estoque na Magazord', ['error' => $e->getMessage()]);
            return $this->errorResponse('Erro ao movimentar estoque: ' . $e->getMessage());
        }
    }



    /////Achar produto por derivação no estoque//////
    public function getProductDerivationStock(string $codeDerivation)
{
    $params = [
        'produto' => $codeDerivation,
    ];

    try {
        $response = $this->api->get('/listEstoque', [
            'query' => $params,
        ]);

        $data = $response->json('data');

        if (empty($data)) {
            return null; 
        }

        // Supondo que Stock::fromMap é um método estático que transforma array em entidade Stock
       // return Stock::fromMap($data[0]);
    } catch (\GuzzleHttp\Exception\RequestException $e) {
        $response = $e->getResponse();
        $status = $response ? $response->getStatusCode() : 500;
        $message = $response ? json_decode($response->getBody()->getContents(), true)['message'] ?? $e->getMessage() : $e->getMessage();

        throw new \Exception("Erro {$status}: {$message}", $status);
    }
}



     /////Ver movimentação de estoque//////
     public function getStockMovement(array $filters)
{
    $page = $filters['page'] ?? 1;
    $limit = $filters['limit'] ?? 10;
    $movementId = $filters['movementId'] ?? null;
    $startDate = $filters['startDate'] ?? null;
    $endDate = $filters['endDate'] ?? null;

    $params = [
        'offset' => ($page - 1) * $limit,
        'limit' => $limit,
        'movimentacaoInicial' => $movementId,
        'dataHoraMovimentacaoInicial' => $startDate ? $this->convertISODateToMagazordFormat($startDate) : null,
        'dataHoraMovimentacaoFinal' => $endDate ? $this->convertISODateToMagazordFormat($endDate) : null,
    ];



    // Remove null params (optional)
    $params = array_filter($params, fn($value) => !is_null($value));

    try {
        $response = $this->api->get('/listMovimentacaoEstoque', [
            'query' => $params,
        ]);

        $responseData = $response->json();

        // Supondo que ResponseTotal::fromMap recebe o array e uma callable para transformar os itens
        //return ResponseTotal::fromMap($responseData, fn($item) => Movement::fromMap($item));
    } catch (\GuzzleHttp\Exception\RequestException $e) {
        $response = $e->getResponse();
        $status = $response ? $response->getStatusCode() : 500;
        $message = $response ? json_decode($response->getBody()->getContents(), true)['message'] ?? $e->getMessage() : $e->getMessage();

        throw new \Exception("Erro {$status}: {$message}", $status);
    }
}




private function convertISODateToMagazordFormat(string $isoDate): string
{
    // Exemplo de conversão, ajuste conforme seu formato esperado pelo Magazord
    $date = new \DateTime($isoDate);
    return $date->format('d/m/Y H:i:s'); // formato típico brasileiro dd/mm/yyyy hh:mm:ss
}
    
    //////Achar produto por caracteristica//////
    public function getProductCharacteristics(string $code): Collection|Response
{
    try {
        $response = $this->api->get("/site/produto/{$code}/caracteristica");

        // Verifica se o dado está no formato ['data' => [...]]
        $data = $response->json('data') ?? $response->json();

        return collect($data);
    } catch (Exception $e) {
        Log::error('Erro ao buscar características do produto na Magazord', ['error' => $e->getMessage()]);
        return $this->errorResponse('Erro ao buscar características do produto: ' . $e->getMessage());
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
