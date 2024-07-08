def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field cpfCnpj  like pessoas.cpfCnpj.
    
def temp-table ttpessoas  no-undo serialize-name "pessoas"  /* JSON SAIDA */
   field cpfCnpj  like pessoas.cpfCnpj
   field descricao  AS CHAR.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field descricaoStatus      as CHAR
    field cpfCnpj  like pessoas.cpfCnpj.

DEF VAR vgeralpessoas AS LOG.
DEF VAR vpessoas AS LOG.
    
hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.

find first ttentrada no-error.
if NOT AVAIL ttentrada then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "sem parametros de entrada".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
    
end.

if ttentrada.cpfCnpj = ""
then do:
    ttentrada.cpfCnpj = ?.
end.

vpessoas = FALSE.
find pessoas WHERE pessoas.cpfCnpj =  ttentrada.cpfCnpj NO-LOCK no-error.
if avail pessoas
then do:
    vpessoas = TRUE.
end.

vgeralpessoas = FALSE.
find geralpessoas WHERE geralpessoas.cpfCnpj =  ttentrada.cpfCnpj NO-LOCK no-error.
if avail geralpessoas
then do:
    vgeralpessoas = TRUE.
end.



IF vpessoas = TRUE
THEN DO: 
    create ttpessoas.
    ttpessoas.descricao = "cadastro existente".
    ttpessoas.cpfCnpj = ttentrada.cpfCnpj.
END.

IF vpessoas = FALSE AND vgeralpessoas = TRUE
THEN DO:  
    create ttpessoas.
    ttpessoas.descricao = "criar pessoas".
    ttpessoas.cpfCnpj = ttentrada.cpfCnpj.
END.

IF vpessoas = FALSE AND vgeralpessoas = FALSE
THEN DO:  
    create ttpessoas.
    ttpessoas.descricao = "cria pessoas geralpessoas".
    ttpessoas.cpfCnpj = ttentrada.cpfCnpj.
END.



find first ttpessoas no-error.

if not avail ttpessoas
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Pessoa nao encontrada".
    ttsaida.cpfCnpj = "".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttpessoas:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).



