
<p  align="center">
<h3 align="center">Api assíncrona aplicando S.O.L.I.D</h3>
</p>

<h2  align="center">Projeto teste </h2>
<p  align="center">Escrito em PHP com Laravel Framework v11.10.0 (PHP v8.2.20) </p>
<p  align="center">API de pagaments</p>

<p  align="center">
<a  href="#install">Instalação</a> •
<a  href="#docs">Documentação</a> •
<a  href="#requirements">Requisitos</a> •
<a  href="#operation">Funcionamento</a> •
<a  href="#tests">Testes</a> 
</p>

## Instalação
<div  id="install">
<p>Para instalação é necessário que o docker e docker-compose estejam devidamente instalados em sua máquina</p>
<p>O sistema está configurado para iniciar no localhost (127.0.0.1) porta 8080, e o mysql iniciará na porta 3306, certifique-se que estas portas estejam livres antes de iniciar a instalação.</p>
 <p>Agora sim vamos iniciar nossa instalação:</p>
 <p>1. Entre na pasta do projeto: </p>
 
```
cd themembers_teste_pratico
```
<p>2. Iremos subir os containeres utilizando o docker-compose (Certifique-se de as portas 8080 e 3306 estejam livres): </p>  

```
docker-compose up -d
```
<p>3. Agora precisamos instalar o composer e atribuir permissões aos diretórios de storage e cache do laravel. Para isso preparei um shell script que fará todo o trabalho, execute o arquivo <b>finish-setup.sh</b> : </p>

```
./finish-setup.sh
```

<p>4. Agora, vamos rodar nossas migrations: </p>

```
docker exec -it php-fpm php artisan migrate
```

<p>5. Pra finalizar, vamos colocar nossa fila pra rodar, rodaremos esse comando individualmente para que possamos acompanhar os logs no terminal: </p>

```
docker exec -it php-fpm php artisan queue:work --queue=default
```

</div>

## Documentação
<div  id="docs">
<p>Após iniciar os containeres corretamente e o sistema estiver funcionando, a página inicial do sistema (127.0.0.1:8080) disponibiliza uma descrição detalhada sobre as requisições e respostas</p>

<p>1. No diretório /documentation estará disponibilizado um diagrama EER do banco de dados</p>

<p>2. Também no diretório /documentation foi disponibilizado uma collection  para acesso via postman</p>

<p>3. Para visualização da collection é necessário que o postman esteja devidamente instalado na em máquina</p>

<p>
	<dl>
	<dd>3.1. Com o programa aberto importe a collection "Themembers.postman_collection.json" clicando no botão "import" no canto superior esquerdo.</dd>
	</d1>
</p>
</div>

## Requisitos
<div id="requirements">
<p>1. <b>Valor amount positivo:</b>  app/Http/Requests/PaymentRequest.php | Linha: 28.</p>
<p>2. <b>Valor payment_method seja um dos valores permitidos ('boleto', 'pix', 'credit_card'): </b>
 app/Http/Requests/PaymentRequest.php | Linha: 29 e app/Enums/PaymentTypesEnum.php</p>
 <p>3. <b>Valor buyer_document no formato correto de CPF:</b>  app/Http/Requests/PaymentRequest.php | Linha: 31, app/Http/Requests/BuyerRequest.php | Linha 27 e app/Rules/CpfValidation.php</p>
<p>4. <b>Processamento assíncrono de pagamento: </b> app/Jobs/ProcessPaymentJob.php</p>
<p>5. <b>Provedores de pagamento distintos: </b> No diretório <b>app/Gateways/Payments/</b>  estão as 3 classes de pagamento, implementando a interface <b>app/Interfaces/PaymentGatewayInterface.php</b>. Os retornos dos respectivos métodos de pagamentos podem ser vistos no log das filas pelo terminal, e também consultados na tabela <b>payments_logs</b>.  </p>
</div>

## Funcionamento
<div id="operation">
<p>A API possui 3 endpoint, que devem ser executados na ordem para o funcionamento adequado.</p>
1. <b>Buyers<b>
<p>Primeiramente vamos cadastrar um comprador (buyer), para isso enviaremos uma requisiçao POST para <b>api/buyer</b>. Para detalhes da requisição acesse a <a href="http://127.0.0.1:8080/">Página Inicial</a>.</p>
2. <b>Products<b>
<p>Agora vamos cadastrar um produto (product), para isso enviaremos uma requisiçao POST para <b>api/product</b>. Para detalhes da requisição acesse a <a href="http://127.0.0.1:8080/">Página Inicial</a>.</p>
3. <b>Payments<b>
<p>Finalmente iremos cadastrar um pagamento (payment), para isso enviaremos uma requisiçao POST para <b>api/payment</b>. Para detalhes da requisição acesse a <a href="http://127.0.0.1:8080/">Página Inicial</a>.</p>
</div>

## Testes
<div id="tests">
<p>Eu implementei alguns exemplos simples de <b>Testes de funcionalidade</b> e <b>Testes unitários</b>. Esses podem ser encontrados no diretório <b>/test</b>.</p>
<p>Para a execução dos testes, executaremos o seguinte comando: </p>

```
docker exec -it php-fpm php artisan test
```
</div>
  
##
As seguintes estão sendo foram usadas na construção do projeto:
- [Laravel](https://laravel.com/)

- [Docker](https://www.docker.com/)

- [Mysql](https://www.mysql.com/)
