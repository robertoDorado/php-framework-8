# Framework PHP 8.2

Este projeto está na versão **8.2** e está configurado para rodar com **Docker**. O PHPUnit já está configurado para testes unitários.

## Requisitos

- Docker e Docker Compose instalados em sua máquina.

## Instalação do projeto na máquina

1. Instalação do ssl em ambiente local

Este guia explica como instalar o `mkcert` em uma máquina Windows utilizando o Chocolatey.

2. Instale o Chocolatey. Se você ainda não possui o Chocolatey instalado, siga as instruções abaixo:

3. Abra o PowerShell **como administrador**. Para isso, clique com o botão direito no ícone do PowerShell e selecione **"Executar como administrador"**.

4. Execute o comando abaixo para instalar o Chocolatey:

    ```powershell
    Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://community.chocolatey.org/install.ps1'))
    ```

## Instalar o mkcert usando o Chocolatey

1. Após instalar o Chocolatey, no mesmo PowerShell **com permissões de administrador**, execute o comando abaixo para instalar o `mkcert`:

    ```powershell
    choco install mkcert -y
    ```

## Verificação

Para verificar se o `mkcert` foi instalado corretamente, você pode executar:

   ```powershell
   mkcert -CAROOT
   ```

## Configuração do projeto

1. Clone este repositório

   ```bash
   git clone https://github.com/robertoDorado/php-framework-8.git
   ```

2. Após a instalação do mkcert na máquina local, faça a instalação da CA na pasta ssl

   ```powershell
   cd php-framework-8
   mkdir ssl
   cd ssl
   mkcert -install localhost
   ```

3. Execute o projeto e atualize as dependências

   ```docker
   docker-compose up -d
   docker exec -it php-apache-sistema-pagamentos-simplificado /bin/bash
   composer update
   ```

4. Execute as migrations dentro do container

   ```docker
   docker exec -it php-apache-8 /bin/bash
   dos2unix shell/migrations.sh
   chmod +x shell/migrations.sh
   shell/migrations.sh