def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "produtos"   /* JSON ENTRADA */
    LIKE produtos.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field descricaoStatus      as char.

def var vmensagem as char.
def var vidProduto as int.

hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.

RUN cadastros/database/produtos.p (INPUT "POST", 
                                           input table ttentrada, 
                                           output vidProduto,
                                           output vmensagem).

IF vmensagem <> ? 
THEN DO:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = vmensagem.
                                          
    hsaida  = temp-table ttsaida:handle.
                                          
    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
END.

create ttsaida.
ttsaida.tstatus = 200.
ttsaida.descricaoStatus = "Produto alterado com sucesso".

hsaida  = temp-table ttsaida:handle.

lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
