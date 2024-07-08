def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field buscaProduto          AS CHAR
    field idProduto             like produtos.idProduto
    field idPessoaFornecedor    like produtos.idPessoaFornecedor
    field refProduto            like produtos.refProduto
    FIELD FiltroAssociados      AS CHAR.

def temp-table ttprodutos  no-undo serialize-name "produtos"  /* JSON SAIDA */
    like produtos
    FIELD idMarca                    LIKE geralprodutos.idMarca
    FIELD codImendes                 LIKE geralprodutos.codImendes
    FIELD idGrupo                    LIKE geralprodutos.idGrupo
    FIELD nomeGrupo                  LIKE fiscalGrupo.nomeGrupo
    FIELD prodZFM                    LIKE geralprodutos.prodZFM
    FIELD geral_eanProduto           LIKE geralprodutos.eanProduto
    FIELD geral_idGeralProduto       LIKE geralprodutos.idGeralProduto
    FIELD geral_nomeProduto          LIKE geralprodutos.nomeProduto
    FIELD dataAtualizacaoTributaria  LIKE geralfornecimento.dataAtualizacaoTributaria
    FIELD idFornecimento             LIKE geralfornecimento.idFornecimento
    FIELD nomeFantasia               LIKE geralpessoas.nomeFantasia
    FIELD cpfCnpj                    LIKE geralpessoas.cpfCnpj.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field descricaoStatus      as char.

def VAR vidProduto like ttentrada.idProduto.
DEF VAR vnomeGrupo AS CHAR.
DEF VAR vdataAtualizacaoTributaria AS DATETIME.
DEF VAR vidFornecimento AS INT.

hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.

vidProduto = 0.
if avail ttentrada
then do:
    vidProduto = ttentrada.idProduto.
    if vidProduto = ? then vidProduto = 0.
end.
if ttentrada.buscaProduto = ""
then do:
    ttentrada.buscaProduto = ?.
end.
if ttentrada.idProduto = 0
then do:
    ttentrada.idProduto = ?.
end.
if ttentrada.idPessoaFornecedor = 0
then do:
    ttentrada.idPessoaFornecedor = ?.
end.
if ttentrada.refProduto = ""
then do:
    ttentrada.refProduto = ?.
end.

IF ttentrada.idProduto <> ? OR (ttentrada.idProduto = ? AND 
                                ttentrada.buscaProduto = ? AND 
                                ttentrada.idPessoaFornecedor = ? AND 
                                ttentrada.refProduto = ? AND
                                ttentrada.FiltroAssociados =? )
THEN DO:
    for each produtos where
        (if vidProduto = 0
        then true /* TODOS */
        ELSE produtos.idProduto = vidProduto)
        no-lock.

        RUN criaProdutos.  
    end.
END.

IF ttentrada.buscaProduto <> ?
THEN DO:
    find produtos where 
        produtos.nomeProduto MATCHES "*" + ttentrada.buscaProduto + "*"
        NO-LOCK no-error.
        
        if avail produtos
        then do:
            RUN criaProdutos.
        end.
END.

IF ttentrada.idPessoaFornecedor <> ? AND ttentrada.refProduto <> ?
THEN DO:
    find produtos where 
        produtos.idPessoaFornecedor = ttentrada.idPessoaFornecedor AND
        produtos.refProduto = ttentrada.refProduto
        NO-LOCK no-error.
        
        if avail produtos
        then do:
            RUN criaProdutos.
        end.
END.

IF ttentrada.FiltroAssociados = 'associados'
THEN DO:
    for each produtos where
        produtos.idGeralProduto <> ?
        no-lock.

        RUN criaProdutos.  
    end.
END.

IF ttentrada.FiltroAssociados = 'naoassociados'
THEN DO:
    for each produtos where
        produtos.idGeralProduto = ?
        no-lock.

        RUN criaProdutos.  
    end.
END.

  

find first ttprodutos no-error.

if not avail ttprodutos
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Produto nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttprodutos:handle.
lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).

/* export LONG VAR*/
DEF VAR vMEMPTR AS MEMPTR  NO-UNDO.
DEF VAR vloop   AS INT     NO-UNDO.
if length(vlcsaida) > 30000
then do:
    COPY-LOB FROM vlcsaida TO vMEMPTR.
    DO vLOOP = 1 TO LENGTH(vlcsaida): 
        put unformatted GET-STRING(vMEMPTR, vLOOP, 1). 
    END.
end.
else do:
    put unformatted string(vlcSaida).
end.


PROCEDURE criaProdutos.

        vnomeGrupo = ?.
        vdataAtualizacaoTributaria = ?.
        vidFornecimento = ?.
        
        FIND geralprodutos WHERE geralprodutos.idgeralproduto = produtos.idgeralproduto NO-LOCK no-error.
        if avail geralprodutos
        then do:
            FIND fiscalgrupo OF geralprodutos NO-LOCK NO-ERROR.
            IF AVAIL fiscalgrupo
            THEN DO:
                vnomeGrupo = fiscalGrupo.nomeGrupo.  
            END.  
            
            FIND pessoas WHERE pessoas.idPessoa = produtos.idPessoaFornecedor NO-LOCK.

            FIND geralpessoas OF pessoas NO-LOCK.
            
            FIND geralfornecimento WHERE 
                                    geralfornecimento.idGeralProduto =  geralprodutos.idGeralProduto AND
                                    geralfornecimento.Cnpj =  pessoas.cpfCnpj
                                NO-LOCK NO-ERROR.
                                
            IF AVAIL geralfornecimento 
            THEN DO:
                vdataAtualizacaoTributaria = geralfornecimento.dataAtualizacaoTributaria.
                vidFornecimento = geralfornecimento.idFornecimento.
            END.
        END.
        
        create ttprodutos.
        BUFFER-COPY produtos TO ttprodutos.
        
        ttprodutos.idMarca = if avail geralprodutos then geralprodutos.idMarca else ?.
        ttprodutos.codImendes = if avail geralprodutos then geralprodutos.codImendes else ?.
        ttprodutos.idGrupo = if avail geralprodutos then geralprodutos.idGrupo else ?.
        ttprodutos.nomeGrupo = vnomeGrupo.
        ttprodutos.prodZFM = if avail geralprodutos then geralprodutos.prodZFM else ?.
        ttprodutos.dataAtualizacaoTributaria = vdataAtualizacaoTributaria.
        ttprodutos.idFornecimento = vidFornecimento.
        ttprodutos.geral_eanProduto = if avail geralprodutos then geralprodutos.eanProduto else ?.
        ttprodutos.geral_idGeralProduto = if avail geralprodutos THEN geralprodutos.idGeralProduto else ?.
        ttprodutos.geral_nomeProduto = if avail geralprodutos THEN geralprodutos.nomeProduto else ?.
        ttprodutos.nomeFantasia = if avail geralpessoas THEN geralpessoas.nomeFantasia else ?.
        ttprodutos.cpfCnpj = if avail geralpessoas THEN geralpessoas.cpfCnpj else ?.
       
END.
