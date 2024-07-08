
// Programa especializado em CRAR a tabela pessoas
def temp-table ttentrada no-undo serialize-name "pessoas"   /* JSON ENTRADA */
    LIKE pessoas.

  
def input param vAcao as char.
DEF INPUT PARAM TABLE FOR ttentrada.
def output param vidPessoa as INT.
def output param vmensagem as char.

vidPessoa = ?.
vmensagem = ?.

find first ttentrada no-error.
if not avail ttentrada then do:
    vmensagem = "Dados de Entrada nao encontrados".
    return.    
end.


if ttentrada.cpfCnpj = ? or ttentrada.cpfCnpj = ""
then do:
    vmensagem = "Dados de Entrada Invalidos".
    return.
end.



if vAcao = "PUT"
THEN DO:

    find pessoas where pessoas.cpfCnpj = ttentrada.cpfCnpj no-lock no-error.
    if avail pessoas
    then do:
        vmensagem = "Pessoa ja cadastrada".
        return.
    end.
    do on error undo:
        create pessoas.
        vidPessoa = pessoas.idPessoa.
        BUFFER-COPY ttentrada EXCEPT idPessoa TO pessoas.
    end.
    
END.
IF vAcao = "POST" 
THEN DO:

    find pessoas where pessoas.idPessoa = ttentrada.idPessoa no-lock no-error.
    if not avail pessoas
    then do:
        vmensagem = "Pessoa nao cadastrada".
        return.
    end.

    do on error undo:   
        find pessoas where pessoas.idPessoa = ttentrada.idPessoa EXCLUSIVE.
        vidPessoa = pessoas.idPessoa.
        
        BUFFER-COPY ttentrada EXCEPT ttentrada.idPessoa TO pessoas .
    end.

    
END.
   

