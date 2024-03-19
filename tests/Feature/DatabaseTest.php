<?php

use App\Models\Product;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

it('should be able o create a product', function () {

    //\Pest\Laravel\withoutExceptionHandling();

    # Criar um produto e lanca no bd um registro
    postJson(
        route('product.store'),
        ['title' => 'Titulo qualquer']
    )->assertCreated();

    # verificar se este registro existe(has) no BD
    assertDatabaseHas('products', ['title' => 'Titulo qualquer']);


    assertTrue(
        Product::query()
            ->where(['title' => 'Titulo qualquer'])
            ->exists()
    );

    assertDatabaseCount('products', 1);
});

it('should be able to update a product', function () {
    $p = Product::factory()->create(['title' => 'Titulo qualquer']);

    # adiciona um produto ao bd
    /* Nesta linha, é feita uma solicitação PUT JSON para a rota 'product.update', passando o ID do produto que foi
     criado anteriormente e um novo título ('Atualizando o titulo') para atualização. O teste verifica se a resposta da
     solicitação é bem-sucedida (status 200 OK).*/
    putJson(
        route('product.update', $p),
        ['title' => 'Atualizando o titulo']
    )->assertOk();


    # o mais usado
    # checa se existe o produto
    /* Esta linha verifica se o banco de dados contém um registro na tabela 'products' com o ID e título correspondentes
       ao produto atualizado.
    */
    assertDatabaseHas('products', [
        'id' => $p->id,
        'title' => 'Atualizando o titulo'
    ]);

    /* Aqui, é feita uma expectativa (assertion) usando um objeto do tipo Product ($p). O método `refresh()` é usado
       para atualizar os dados do objeto a partir do banco de dados, garantindo que as alterações feitas pela solicitação
       PUT sejam refletidas no objeto. Em seguida, verifica-se se o título do produto foi atualizado com sucesso para
      'Atualizando o titulo'.
     */
    expect($p)->refresh()->title->toBe('Atualizando o titulo');
    assertSame('Atualizando o titulo', $p->title);
    assertDatabaseCount('products', 1);

});


it('should be able to delete a product', function () {

});





