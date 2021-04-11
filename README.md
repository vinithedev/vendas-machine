# Cadastro de cliente CRUD

/clients <-OK

POST -> 201 ( Created ) <-OK

- ID ( Gerado) <-OK
- Nome <-OK
- Documento ( Validado Rg, CPF) <- OK
- email <- OK

```json
{
    "name": "eu",
    "email": "umemail@legal.com",
    "document": "12345679"
}
```

GET -> clients/{id} 200 <- OK
```json
{
    "id": 1,
    "name": "eu",
    "email": "umemail@legal.com",
    "document": "12345679"
}
```
Se não encontrar, retorna 404 <- OK





GET /clients <- OK

PARAMS
    - Data Para frente do pedido <-OK
    - Até Valor do Pedido ( Pedidos com valor até tanto) <-OK
    - Acima de valor do Pedido ( Pedidos com valor até tanto) <-OK
    - Exportar como relatório `Se passar o parametro deverá exportar como um relatório e enviar por e-mail, fazer como um job.` <-OK

```json
[
    {
        "id": 1,
        "name": "eu",
        "orders": [
            {
                "id": 1,
                "produts": [...],
                "value": 125.50, //Valor na data da compra
            }
        ]
    }
]
```


Em caso de falha retornar um Bad Request ( 400 ) <- OK
Exemplo de retorno.
```json

{
    "success": false,
    "errors": [
        {
            "field": "document",
            "message":  "Documento inválido."
        },
        {
            "field": "name",
            "message": "O nome é requerido"
        },
        {
            "field": "email",
            "message": "O e-mail precisa ser válido."
        }
    ]
}

```


Para pesquisa

/products <-OK

POST -> 201 ( Created )  <-OK

- ID ( Gerado) <-OK
- Nome <-OK
- price <-OK


```json
{
    "name": "Nome do produto",
    "price": 10.5
}
```

GET -> products/{id} 200 <-OK
```json
{
    "id": 1,
    "name": "Nome do produto",
    "price": 10.5
}
```
Se não encontrar, retorna 404 <-OK


Em caso de falha retornar um Bad Request ( 400 ) <-OK
Exemplo de retorno.
```json

{
    "success": "false",
    "errors": [
        {
            "field": "price",
            "message":  "O preço é obrigatório"
        }
    ]
}
```



/order <-OK

POST -> 201 ( Created ) <-OK

- ID ( Gerado) <-OK
- client <-OK
- produtos <-OK
- total <- OK



1 - Haja autenticação. ( Caso não esteja autenticado retona no NOT_AUTHORARIZED) <-OK
2 - Migrations disso tudo. `php migration` ( deve conseguir subir toda a base.) <-OK
3 - Logs Relatório de vendas e de quem vendeu. Precisa ser um arquivo, não pode ser um JSON e precisa ser baixado. <- OK
4 - Ao concluír uma compra, enviar um e-mail de validação. ( faça como um Job ) <-OK


- Métodos no máximo de 100 linhas
- Quantidade de ifs

