# ESP01 Data Logger

Este projeto consiste em um sistema para capturar e armazenar números aleatórios gerados por um ESP8266, enviá-los para um servidor via requisição HTTP POST e exibir os últimos registros em uma página web com atualização em tempo real. Além da exibição em tabela, os dados são apresentados em um gráfico interativo.

## 📌 Tecnologias Utilizadas
- **ESP8266** para envio dos dados
- **PHP** para recepção e armazenamento no banco de dados
- **MySQL** para persistência dos dados
- **JavaScript** (Fetch API) para atualização dinâmica da página
- **Chart.js** para exibição dos dados em gráfico
- **Apache** para servir os arquivos do sistema

## 📂 Estrutura do Projeto
```
/
├── esp_customer/
│   ├── esp_customer.ino  # Código do ESP8266 para envio de dados
├── server/
│   ├── index.php           # Página para exibir os dados em tempo real
│   ├── get_data.php        # API para recuperar os últimos registros
│   ├── index.php           # Index para visualizar os dados do ESP8266
├── README.md               # Este arquivo de documentação
```

## 🔧 Configuração do Servidor
1. Instale o Apache, PHP e MySQL no seu servidor.
2. Crie um banco de dados chamado `esp01` e uma tabela chamada `esp01` com a seguinte estrutura:

```sql
CREATE DATABASE esp01;
USE esp01;
CREATE TABLE esp01 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    number INT NOT NULL,
    data DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

3. Configure o Apache para aceitar conexões na pasta do projeto e habilite o mod_rewrite se necessário.

## 📡 Configuração do ESP8266
1. Faça o upload do código **esp_customer.ino** para o ESP8266.
2. No código, configure o **SSID** e a **senha do Wi-Fi**.
3. Altere o IP do servidor no código `#define SERVER_IP "SEU_IP"`.

## 📊 Exibição dos Dados
Acesse `http://seu-dominio-ou-ip/index.php` para visualizar a tabela e o gráfico em tempo real.

## 📌 Teste Manual via cURL
Caso queira testar a API manualmente, use:
```sh
curl -X POST http://seu-dominio-ou-ip/post_data.php -H "Content-Type: application/json" -d '{"randomNumber": 12345678}'
```

## 📄 Licença
Este projeto é de código aberto e pode ser utilizado e modificado livremente.

