# Sistema de Gestão de Ementas - Bar AAUALG

Este é um sistema web desenvolvido para a Associação Académica da Universidade do Algarve (AAUALG), focado na gestão de ementas e alérgenos do bar universitário. O sistema foi implementado utilizando uma arquitetura de microserviços com Docker, PHP e MySQL, distribuída em três contentores.

## Sobre o Projeto

O sistema foi desenvolvido para atender às necessidades específicas do bar da AAUALG, permitindo a gestão eficiente das ementas semanais e o acesso fácil às informações pelos utentes do bar. A aplicação segue uma arquitetura de microserviços distribuída em três contentores Docker:

1. **Servidor Web (HTTP+PHP)**: Responsável pela interface do usuário e lógica de negócios
2. **Base de Dados Principal**: Gerencia as tabelas de Ementas e Pratos
3. **Base de Dados de Suporte**: Controla Alérgenos e Autenticação

## Autor

Bernardo Pereira (a76842)

## Funcionalidades Principais
### Interface Pública (Front-Office)
- Visualização da ementa semanal do bar
- Consulta de informações sobre pratos
- Acesso a informações sobre alérgenos
- Interface responsiva para dispositivos móveis

### Interface Administrativa (Back-Office)
- Sistema de autenticação seguro
- Painel administrativo intuitivo com gestão completa (CRUD) de:
  - Ementas semanais
  - Pratos
  - Alérgenos

## Requisitos do Sistema

- Docker e Docker Compose
- Navegador web

## Estrutura do Projeto

```
├── www/                    # Diretório principal da aplicação
│   ├── admin.php           # Painel de administração
│   ├── index.php           # Página inicial pública
│   ├── login.php           # Página de login
│   ├── assets/             # Recursos estáticos
│   ├── css/                # Estilos CSS
│   ├── includes/           # Componentes PHP
│   └── scripts/            # Scripts auxiliares
├── docker-compose.yml      # Configuração Docker
└── Scriptsbd.txt          # Scripts de banco de dados
```

## Banco de Dados

O sistema utiliza duas bases de dados MySQL:

### ementas_db
- Tabela `Prato`: Armazena informações dos pratos
- Tabela `Ementas`: Gerencia as ementas diárias
- Tabela `Utilizador`: Dados de autenticação

### alergenos_db
- Tabela `Alergenos`: Gerencia os alérgenos

## Instalação e Configuração
Docker Compose
1. execute no diretório do projeto:
   ```bash
   docker-compose up -d
   ```
2. Aguarde até que todos os contentores estejam em execução
3. Acesse a aplicação em `http://localhost`

Nota: Todos os arquivos necessários já estão incluídos no projeto, incluindo os scripts de banco de dados e configurações do Docker.

## Acesso ao Sistema

- **Área Pública**: Visualização das ementas
- **Área Administrativa**: Acesso através do login (requer autenticação)
- User: admin Password: admin

## Segurança

- Autenticação de usuários implementada
- Proteção contra SQL Injection
- Senhas armazenadas com hash

## Tecnologias Utilizadas

- PHP
- MySQL
- Docker
- Bootstrap 4.5
- HTML5/CSS3
