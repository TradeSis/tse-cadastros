def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "pessoas"   /* JSON ENTRADA */
    like pessoas.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field idPessoa        as int serialize-name "idPessoa"
    field descricaoStatus      as char.

DEF VAR vidPessoa as INT.
def var vmensagem as char.

hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.

vidPessoa = 0.
RUN cadastros/database/pessoas.p (INPUT "PUT", 
                                     input table ttentrada, 
                                     output vidPessoa,
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
find last pessoas no-lock.
ttsaida.tstatus = 200.
ttsaida.idPessoa = vidPessoa.
ttsaida.descricaoStatus = "Pessoa cadastrada com sucesso".

hsaida  = temp-table ttsaida:handle.

lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
