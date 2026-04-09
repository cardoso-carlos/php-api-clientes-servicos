# Modelagem Inicial

## Entidades
- Cliente
- Servico
- Usuario
- Agendamento

## Relacionamentos
- Um cliente pode ter vários agendamentos
- Um serviço pode estar em vários agendamentos
- Um agendamento pertence a um cliente
- Um agendamento pertence a um serviço

## Regras de negócio iniciais
- Cliente deve ter nome e email válidos
- Serviço deve ter nome e valor válidos
- Usuário deve ter email único
- Perfil do usuário deve ser admin ou atendente
- Agendamento deve ter cliente, serviço, data e status válidos