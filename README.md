Bot para discord beeemmmm rudimentar somente para exemplo de uso básico da biblioteca [DiscordPHP](http://discord-php.github.io/DiscordPHP/).

* Permite adicionar comandos simples de resposta de texto.
* Rolagem de dados.
* Censura de palavras proibidas.
* Apagar mensagens repetidas.
* Mensagem de bem-vindo.
* Aviso de pedido de ajuda no *channel* errado
* Mensagens agendadas
* Envio de imagens selecionadas por comando.


### Uso - Teste na verdade

Renomeie o arquivo `.env.example` para `.env`, adicione o *token* de seu bot, id do canal de ajuda e id do canal de boas-vindas.

rode com 

```
    php run.php
```

#### Adicionando Comandos de texto Simples

Para adicionar comandos de texto edite o arquivo `comandds-simple-text.json`, a chave é o comando e valor é a mensagem que será enviada.

#### Rolando dados 

Para rolar dados utilize o comando !roll <expressão_dado>. Ex.: `!roll 1d6`, `!roll 2d10`, `!roll 3d20+8` 

#### Censura de palavras proibidas

Edite as palavras no arquivo `censorship-words.json`

#### Mensagem de boas-vindas

Edite o arquivo `welcome-message.txt`, como texto puro. A marcação [MEMBER]  será substituida pelo username do membro.

#### Mensagem agendada

Edite o arquivo `scheduled-messages.json` com a data, mensagem a ser enviada e o id do *channel* em que a mensagem vai ser enviada.