
// Programa especializado em CRAR a tabela produtos
def temp-table ttentrada no-undo serialize-name "produtos"   /* JSON ENTRADA */
    LIKE produtos.

//---------- geralprodutos -------------    
def temp-table ttgeralprodutos no-undo serialize-name "geralprodutos"   
    LIKE geralprodutos.  
    
//---------- geralfornecimento -------------    
def temp-table ttgeralfornecimento no-undo serialize-name "geralfornecimento"   
    LIKE geralfornecimento. 
    
    
def input param vAcao as char.
DEF INPUT PARAM TABLE FOR ttentrada.
def output param vidProduto as INT.
def output param vmensagem as char.
DEF VAR vCnpj AS CHAR.
def VAR vidfornecimento AS INT. 

vidProduto = ?.
vmensagem = ?.

find first ttentrada no-error.
if not avail ttentrada then do:
    vmensagem = "Dados de Entrada nao encontrados".
    return.    
end.


if vAcao = "PUT"
THEN DO:
    if ttentrada.nomeProduto = ?
    then do:
        vmensagem = "Dados de Entrada Invalidos".
        return.
    end.

    if ttentrada.eanProduto = 0
    then do:
        ttentrada.eanProduto = ?.
    end.
    
    if ttentrada.idGeralProduto = ? AND   ttentrada.eanProduto <> ? /* helio 17/05/2024 - nao ria geralproduto sem ean */
    then do:

            CREATE ttgeralprodutos.
            ttgeralprodutos.eanProduto    =  ttentrada.eanProduto.
            ttgeralprodutos.nomeProduto   =  ttentrada.nomeProduto.
            
            RUN admin/database/geralprodutos.p (INPUT "PUT", 
                                                   input table ttgeralprodutos,
                                                   OUTPUT ttentrada.idGeralProduto,
                                                   OUTPUT vmensagem). 
    end.
    
    find produtos where 
        produtos.idGeralProduto = ttentrada.idGeralProduto AND 
        produtos.idPessoaFornecedor = ttentrada.idPessoaFornecedor and
        produtos.refprod    =  ttentrada.refProduto
        no-lock no-error.
    if avail produtos
    then do:
        vidProduto = produtos.idproduto.
        vmensagem = "Produto ja cadastrado".
        return.
    end.
    do on error undo:
        create produtos.
        vidProduto = produtos.idProduto.
        produtos.idGeralProduto   = ttentrada.idGeralProduto.
        produtos.idPessoaFornecedor   = ttentrada.idPessoaFornecedor.
        produtos.refProduto   = ttentrada.refProduto.
        produtos.eanproduto   = ttentrada.eanproduto.
        produtos.nomeProduto   = ttentrada.nomeProduto.
        produtos.valorCompra   = ttentrada.valorCompra.
        produtos.substICMSempresa   = ttentrada.substICMSempresa.
        produtos.substICMSFornecedor   = ttentrada.substICMSFornecedor.
        produtos.codigoNcm   = ttentrada.codigoNcm.
        produtos.codigoCest   = ttentrada.codigoCest.
    end.
    
END.
IF vAcao = "POST" 
THEN DO:
    if ttentrada.idProduto = ?
    then do:
        vmensagem = "Dados de Entrada Invalidos".
        return.
    end.

    find produtos where produtos.idProduto = ttentrada.idProduto no-lock no-error.
    if not avail produtos
    then do:
        vmensagem = "Produto nao cadastrado".
        return.
    end.
    
    FIND pessoas WHERE pessoas.idPessoa = produtos.idPessoaFornecedor NO-LOCK NO-ERROR.
    IF AVAIL pessoas 
    THEN DO:
       vCnpj = pessoas.cpfCnpj.
       
        FIND geralfornecimento WHERE geralfornecimento.refProduto = produtos.refProduto AND geralfornecimento.Cnpj = vCnpj NO-LOCK NO-ERROR.
        IF NOT AVAIL geralfornecimento 
        THEN DO:
                CREATE ttgeralfornecimento.
                ttgeralfornecimento.Cnpj    =  vCnpj    .
                ttgeralfornecimento.idGeralProduto   =  produtos.idGeralProduto.
                ttgeralfornecimento.refProduto   =  produtos.refProduto.
                ttgeralfornecimento.valorCompra   =  produtos.valorCompra.
                
                RUN admin/database/geralfornecimento.p (INPUT "PUT", 
                                                        input table ttgeralfornecimento, 
                                                        output vidfornecimento,
                                                        output vmensagem).    
        END.
    END.
    
   

    do on error undo:   
        find produtos where produtos.idProduto = ttentrada.idProduto exclusive no-error.
        BUFFER-COPY ttentrada TO produtos .
    end.

    
END.
   


