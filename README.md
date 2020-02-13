# Gerenciamento de Palestras

[![Actions Status](https://github.com/allysonsilva/conference-talks-management/workflows/Continuous%20Integration%20APP%20Laravel/badge.svg)](https://github.com/allysonsilva/conference-talks-management/actions)

## Introdução ao problema

A aplicação deve expor uma API, que irá receber o payload descrevendo a entrada e retornar a saída correspondente, conforme o exemplo/testes dado. De acordo com o algoritmo e critérios de ordenação utilizados, os valores na saída podem ser diferentes do exemplo. O código deve executar por si só.

### Contexto

```
Conference [HasMany] Tracks
Tracks [HasMany] Sessions
Sessions [HasMany] Talks
```

Sua empresa está organizando um grande evento de programação, e recebeu muitas propostas de palestras para serem apresentadas. O problema é fazer todas elas encaixarem no tempo -- tem muitas possibilidades! Então você decidiu escrever um programa pra fazer isso pra você.

- Será um único dia de conferência, mas ocorrerão muitas trilhas simultaneamente.
- Cada trilha tem uma sessão de manhã e outra de tarde. Cada sessão pode conter muitas palestras.
- As sessões da manhã devem começar às 9 horas da manhã e terminar a tempo do almoço, que será servido às 12 (meio dia).
- As sessões da tarde devem começar à 1 da tarde e terminar a tempo do happy hour.
- O happy hour não pode começar antes das 4 da tarde, nem depois das 5 da tarde. 
- O horário do happy hour deve ser o mesmo para todas as trilhas.
- Programa pode considerar que não haverá uma palestra com números no nome.
- A duração das palestras será dado em minutos ou com a string "lightning" indicando que ela durará 5 minutos.
- Os palestrantes serão muito pontuais, não precisa colocar um intervalo entre uma palestra e outra.

#### Test input

```
Writing Fast Tests Against Enterprise Rails 60min
Overdoing it in Python 45min
Lua for the Masses 30min
Ruby Errors from Mismatched Gem Versions 45min
Common Ruby Errors 45min
Rails for Python Developers lightning
Communicating Over Distance 60min
Accounting-Driven Development 45min
Woah 30min
Sit Down and Write 30min
Pair Programming vs Noise 45min
Rails Magic 60min
Ruby on Rails: Why We Should Move On 60min
Clojure Ate Scala (on my project) 45min
Programming in the Boondocks of Seattle 30min
Ruby vs. Clojure for Back-End Development 30min
Ruby on Rails Legacy App Maintenance 60min
A World Without HackerNews 30min
User Interface CSS in Rails Apps 30min
```

#### Test output

```
Track 1:
09:00AM Writing Fast Tests Against Enterprise Rails 60min
10:00AM Overdoing it in Python 45min
10:45AM Lua for the Masses 30min
11:15AM Ruby Errors from Mismatched Gem Versions 45min
12:00PM Lunch
01:00PM Ruby on Rails: Why We Should Move On 60min
02:00PM Common Ruby Errors 45min
02:45PM Pair Programming vs Noise 45min
03:30PM Programming in the Boondocks of Seattle 30min
04:00PM Ruby vs. Clojure for Back-End Development 30min
04:30PM User Interface CSS in Rails Apps 30min
05:00PM Networking Event

Track 2:
09:00AM Communicating Over Distance 60min
10:00AM Rails Magic 60min
11:00AM Woah 30min
11:30AM Sit Down and Write 30min
12:00PM Lunch
01:00PM Accounting-Driven Development 45min
01:45PM Clojure Ate Scala (on my project) 45min
02:30PM A World Without HackerNews 30min
03:00PM Ruby on Rails Legacy App Maintenance 60min
04:00PM Rails for Python Developers lightning
05:00PM Networking Event
```

## Características Importantes

- Executando o [CI/CD](./.github/workflows/ci-workflow.yml) utilizando [GitHub Actions](https://github.com/features/actions)
- Cobertura de testes em **100%**
- Usando **DDD** como orientação e conceitos, não como via de regras puristas
- Arquitetura modular, testável, simples e escalonável
- [*Documentação*](./documentation.yml) seguindo a especificação da [OpenAPI Specification](https://github.com/OAI/OpenAPI-Specification/blob/master/versions/3.0.1.md)
- Utilizando [`commitlint`](https://github.com/conventional-changelog/commitlint) para boas práticas de mensages de commit
- Utilizando o pacote [`lint-staged`](https://github.com/okonet/lint-staged) em combinação com [`husky`](https://github.com/typicode/husky) para executar uma série de comandos que estão representados no arquivo [`lint-staged.config.js`](./lint-staged.config.js) apenas para os arquivos que estão em `stage`, prontos para serem consolidades(commit). Esse hook é executado antes do commit final
- Utilizando [**PHPMD**](https://phpmd.org/), [**PHPCS**](https://github.com/squizlabs/PHP_CodeSniffer), [**PHPStan**](https://github.com/phpstan/phpstan), [**PHPUnit**](https://phpunit.readthedocs.io/en/8.5/index.html) para testes, **QUALIDADE** e **PADRONIZAÇÃO** no código, deixao mais legível e manutenível, além de garantir todo um nívelamento/padrão do mundo PHP

## Instalação

### Requerimentos do servidor

- **PHP >= 7.4.0**
- BCMath PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- **Xdebug** PHP Extension
- [**DS**](https://medium.com/@rtheunissen/efficient-data-structures-for-php-7-9dda7af674cd) [PHP Extension](https://www.php.net/manual/en/book.ds.php)

### Setup da aplicação

- Baixar as dependências executando o comando `composer run-script --ansi setup-init`
- Instalar as dependências para utilização do `pre-commit` e `commitlint`  com o comando node `npm i`
- Para visualizar as rotas, e realizar requisições, é necessário ler o arquivo [`documentation.yml`](./documentation.yml) por meio de uma plataforma que implemente a especificação `OpenAPI`.
  - Pode ser feito copiando a URL do arquivo [`documentation.yml`](./documentation.yml) para o editor [https://petstore.swagger.io/](https://petstore.swagger.io/), ou copiando o conteúdo do mesmo arquivo e colando em [https://editor.swagger.io/](https://editor.swagger.io/)

## Testes

> Toda a aplicação está sendo coberta por testes unitários, funcionais e de API/Integração.

- Para maior velocidade nos testes unitários, utiliza-se a biblioteca [`brianium/paratest`](https://github.com/paratestphp/paratest) que em combinação com **PHPDBG**, ganha-se mais velocidade por conta da paralelização dos testes utilizando todos os cores da CPU
- Para executar os testes e verificar os resultados execute o comando `composer run-script --ansi tests`
- Pode-se verificar cada teste por meio de [hooks](https://phpunit.readthedocs.io/en/8.5/extending-phpunit.html#extending-the-testrunner) que são executados de acordo com a operação. Atualmente existe uma [configuração](tests/Runners/ResultAfterTestExtension.php) no [`phpunit`](phpunit.xml#L28) que permite manipular e salvar em um banco [*SQlite*](tests/database.sqlite) a duração de cada teste. Isso proporciona saber os testes que estão mais lentos para manipular e trabalhar em cima dos mesmos.

## Arquitetura

> *Qualquer que seja a estrutura de pastas que você use, o mais importante é que você comece a pensar em grupos de conceitos de negócios relacionados, em vez de em grupos de códigos com as mesmas propriedades técnicas.*

> *Deve-se estruturar o código com base em seu significado no mundo real, em vez de base em propriedades técnicas.*

1. **Testabilidade** - Se não consigo executar um teste, como sei se ele realmente funciona? Os testes devem descrever não apenas que seu código funciona, mas também como usá-lo.
2. **Legibilidade** - Para mim, se não for bonito, não quero olhar!
3. **Manutenção** - Utiliza-se ferramentas como `PHPCS`, `PHPMD` para trabalhar em cima de padronização e qualidade, como ***clean code*** ou ***object calisthenics***.
4. **Simplicidade** - Escrevemos código para resolver um problema, não para criar um problema.
5. **Consistência** - Se eu entendo uma coisa que um DEV escreveu, eu devo continuar com o resto da mesma maneira, se não mais rápido.

### Blocos de construção do Model Driven Design (MDD)

#### Presentation/Interfaces

- Parte responsável pela exibição de informações do sistema ao usuário e também por interpretar comandos do usuário;

- O objetivo de um aplicativo é obter a entrada do usuário, transmiti-la ao domínio e representar a saída de uma maneira utilizável para o usuário.

- Os controladores são responsáveis pela camada de apresentação do DDD. Esteja criando uma API ou um aplicativo que retorne visualizações HTML, os controladores são responsáveis por apresentar esse conteúdo a quem consome. As classes de comando personalizadas do `artisan` também podem ser consideradas parte da camada de apresentação.

A primeira coisa importante a entender é que um projeto pode ter várias interfaces/aplicativos. De fato, todo projeto do Laravel já possui dois por padrão: os aplicativos HTTP e Console. Ainda assim, existem várias outras partes do seu projeto que podem ser consideradas como um aplicativo independente: toda integração de terceiros, uma API REST, um painel Admin e outros itens. Tudo isso pode ser considerado como interfaces/aplicativos separados, expondo e apresentando o domínio para seus próprios casos de uso exclusivos.

Como estamos no desenvolvimento da Web, nosso foco principal provavelmente estará nos aplicativos relacionados ao HTTP. Então, o que está incluído neles?

```
.
├── Constants
├── Contracts
├── Controllers
├── Entity
├── Middlewares
├── Providers
├── Resources
│   └── Views
├── Routes
├── Rules
├── Services
└── ValueObjects
```

*Da mesma forma que a camada de domínio está agrupada em **código por contexto**, deve-se também ser feito isso na camada da interface/aplicativo, fazendo com que os aplicativos nessa camada possuam todos os mesmos benefícios da camada de domínio.*

- Em um contexto de fatura o código da camada de interface/aplicativo seria algo parecido com isso:

```
Admin
└── Invoices
    ├── Controllers
    │   ├── InvoiceStatusController.php
    │   └── InvoicesController.php
    ├── Providers
    │   ├── InvoiceInterfaceServiceProvider.php
    │   └── RouteServiceProvider.php
    ├── Filters
    │   └── InvoiceStatusFilter.php
    ├── Middleware
    ├── Queries
    │   └── InvoiceCollectionQuery.php
    ├── Requests
    │   └── InvoiceRequest.php
    ├── Transformers
    │   ├── InvoiceCollectionResource.php
    │   └── InvoiceResource.php
    └── ViewModels
        ├── InvoiceCollectionPreviewViewModel.php
        ├── InvoiceIndexViewModel.php
        └── InvoiceStatusViewModel.php
```

Quando você trabalha no contexto de faturas, tem um lugar para saber qual código está disponível. Eu costumo chamar esses grupos de "módulos de aplicativos" ou "módulos" para abreviar; e posso dizer por experiência que eles facilitam muito a vida quando você está trabalhando em projetos de média e grande complexibilidade/escala.

#### Application

- Define os trabalhos (casos de uso) que o software deve executar e coordena os objetos do domínio para solucionar problemas. Essa camada é mantida fina. Ele não contém regras ou conhecimento de negócios, mas apenas coordena tarefas e delegados trabalham para colaborações de objetos de domínio na próxima camada abaixo. Não possui um estado que reflita a situação do negócio, mas pode ter um estado que reflita o progresso de uma tarefa para o usuário ou o programa.

- Essa camada não possui lógica de negócio. Ela é apenas uma camada fina, responsável por conectar/orquestrar a Interface de Usuário às camadas inferiores(Domínio e Infra-estrutura) para executar tarefas de alto nível no aplicativo.

#### Domain

- Responsável por representar conceitos do negócio, informações sobre a situação do negócio e regras de negócio. O estado que reflete a situação do negócio é controlado e usado aqui, mesmo que os detalhes técnicos do armazenamento sejam delegados à infraestrutura. Essa camada é o coração do software comercial.

- Representa os conceitos, regras e lógica de negócios. Todo o foco do DDD está nesta camada. A comunicação com outros sistemas, detalhes de persistência, é encaminhada para a camada de infraestrutura;

- A camada de domínio contém toda a lógica de negócios e é o coração da aplicação. Essa camada pode ficar confusa ao usar o Eloquent, pois seus modelos de domínio conhecem o seu banco de dados. Se ignorar esse aspecto e usar apenas repositórios para interagir com o banco de dados, acredito que pode satisfazer o requisito de separar essas preocupações suficientemente.

- Você também pode chamá-los de "grupos", "módulos"; Seja qual for o nome que você preferir, os domínios descrevem um conjunto de problemas de negócios que você está tentando resolver. Esses grupos são o que chamo de domínios. Eles visam agrupar conceitos dentro do seu projeto que pertencem um ao outro. Se concentrará em um conjunto de regras e práticas para manter seu código bem ordenado e que represente conceitos do negócio no mundo real.

- Os domínios são divididos em áreas separadas, assim, temos a capacidade de desenvolver um domínio inteiro, sem precisar escrever um único controller ou view. Tudo no domínio é facilmente testável e quase todos os domínios podem ser desenvolvidos lado a lado com outros domínios.

- Depois que um domínio é concluído, ele pode ser consumido. O domínio em si não se importa quando ou onde é usado, suas regras de uso são claras para quem o utiliza.

- A estruturação do código nos domínios aumenta a eficiência entre os desenvolvedores em um único projeto. Além disso, diminui a complexidade da manutenção, porque os domínios são separados e bem testados.

- Pensamento de domínios deve ser em grupos de conceitos de negócios relacionados, em vez de em grupos de código com as mesmas propriedades técnicas. Em outras palavras: agrupe o código com base no que ele se representa no mundo real, em vez de seu objetivo na base de código.

- O código da camada de `Domain` e o da camada `Interface` são duas coisas separadas. A camada de `Interface` têm permissão para usar vários grupos do domínio de uma só vez, se necessário, expondo a funcionalidade do domínio ao usuário final.

Observando um aplicativo padrão do Laravel, o código que descreve um único sistema geralmente se espalha por vários diretórios:

```
app
├── Enums
│   ├── ContractDurationType.php
│   └── ContractType.php
├── Exceptions
│   └── InvalidContractDate.php
├── Models
│   └── Contract.php
└── Rules
    ├── ContractAvailabilityRule.php
    └── ContractDurationRule.php
```

*Essa estrutura foi a primeira luta que me levou a procurar uma solução melhor.*

Então, por que não agrupar em módulos/grupos? Parece algo como isto:

```
Domain
├── Contracts
├── Invoicing
└── Users
```

> Pasta de `Domain` representa ***Uma esfera especificada de atividade ou conhecimento***.

Agrupamos o código com base em sua esfera de atividade, seu domínio. Vamos ampliar uma pasta de domínio específica:

```
Contracts
├── Actions
├── Console
│   └── Commands
├── DataObjects
├── Events
├── Exceptions
├── Listeners
├── Rules
├── Models
│   └── Queries
├── Providers
└── ValueObjects
```

Uma **Action** é uma classe que executa uma operação dentro do domínio. Pode ser uma tarefa simples, como criar ou atualizar um modelo, ou algo mais complexo, seguindo uma ou várias regras de negócios, como aprovar um contrato. Como uma única `action` se concentra apenas em uma tarefa, elas são extremamente flexíveis: uma `action` pode ser composta por outras `actions` e pode ser utilizada via [`IoC`](https://github.com/allysonsilva/estudos/blob/bbfbdc0d13edb8a88553f9af9e7d2744c9b9e4dc/Arquitetura/Inje%C3%A7%C3%A3o%20de%20depend%C3%AAncia.md) e [`DI`](https://github.com/allysonsilva/estudos/blob/master/Arquitetura/SOLID.md#d-dependency-inversion-principle-dip).

#### Infrastructure

- A camada de infraestrutura lida com qualquer coisa que interaja com código ou serviços fora da aplicação. Isso inclui coisas como e-mails, chamadas de API e, interações com o banco de dados. A pasta de `app/Support` faz parte dessa camada.
- Fornece recursos técnicos que darão suporte às camadas superiores e adjacentes. São normalmente as partes de um sistema responsáveis por persistência de dados, conexões com bancos de dados, envio de mensagens por redes, gravação e leitura de discos, etc.

### Resumo

- O código de domínio(`./app/Domain`) contém toda a lógica de negócios e é usado pela camada de `Interfaces`(`./app/Interfaces`).

- Mesmo sendo um desenvolvedor, seu principal objetivo é entender o problema de negócios e traduzi-lo em código. O código em si é apenas um meio para atingir um fim; mantenha sempre o foco no problema que está resolvendo.

- O mais importante é que você comece a pensar em grupos de conceitos de negócios relacionados, em vez de em grupos de códigos com as mesmas propriedades técnicas.

- Não se trata de escrever a menor quantidade de caracteres; trata da elegância e de facilitar a navegação por grandes bases de código, permitir o mínimo de espaço possível para confusão e manter o projeto em funcionamento por longos períodos de tempo.

- Agrupe seu código com base no que ele se parece no mundo real, em vez de seu objetivo na base de código.

-------

A camada de interfaces/aplicativos conterá um ou vários aplicativos. Cada aplicativo pode ser visto como um aplicativo isolado, com permissão para usar todo o domínio. Em geral, os aplicativos não se comunicam. Um exemplo pode ser um painel de administração HTTP padrão e outro pode ser uma API REST.

Como uma visão geral de alto nível, veja como pode ser a estrutura de pastas de um projeto orientado a domínio:

```
One specific domain folder per business concept
app/Domain/Invoices/
    ├── Actions
    ├── QueryBuilders
    ├── Collections
    ├── DataObjects
    ├── Events
    ├── Exceptions
    ├── Listeners
    ├── Models
    ├── Rules
    └── Providers

app/Domain/Customers/
    // …
```

E é assim que a camada de interfaces/aplicativo seria:

```
The admin HTTP application
app/Interfaces/Admin/
    ├── Controllers
    ├── Middlewares
    ├── Requests
    ├── Resources
    └── ViewModels

The REST API application
app/Interfaces/Api/
    ├── Controllers
    ├── Middlewares
    ├── Requests
    └── Resources

The console application
app/Interfaces/Console/
    └── Commands
```

## Benefícios Utilização DDD:

- **Alinhamento do código com o negócio**: O contato dos desenvolvedores com os especialistas do domínio é algo essencial quando se faz DDD;
- **Favorecer reutilização**: Os blocos de construção, facilitam aproveitar um mesmo conceito de domínio ou um mesmo código em vários lugares;
- **Mínimo de acoplamento**: Com um modelo bem feito, organizado, as várias partes de um sistema interagem sem que haja muita dependência entre módulos ou classes de objetos de conceitos distintos;
- **Independência da Tecnologia**: DDD não foca em tecnologia, mas sim em entender as regras de negócio e como elas devem estar refletidas no código e no modelo de domínio. Não que a tecnologia usada não seja importante, mas essa não é uma preocupação de DDD.

-------

Referências:

- https://jenssegers.com/goodbye-controllers-hello-request-handlers
- https://stitcher.io/blog/laravel-beyond-crud
- https://stitcher.io/blog/organise-by-domain
- https://medium.com/@remi_collin/keeping-your-laravel-applications-dry-with-single-action-classes-6a950ec54d1d
