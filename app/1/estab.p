def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */


def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field etbcod  like estab.etbcod
    field linha  AS int
    field qtd  AS int
    field botao  AS char.

def temp-table ttestab  no-undo serialize-name "estab"  /* JSON SAIDA */
    FIELD etbcod like estab.etbcod
    FIELD etbnom like estab.etbnom
    FIELD munic like estab.munic
    FIELD supcod like estab.supcod
    FIELD supnom LIKE supervisor.supnom.
    
def temp-table tttotal  no-undo serialize-name "total"  /* JSON SAIDA */
    field qtdRegistros   as char
    FIELD linha  AS int.


def dataset conteudoSaida for ttestab, tttotal.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field retorno      as char.

def var vsupnom   as char.

def query q-leitura for estab scrolling.
def var vlinha as int.
def var vqtd as int.
def var vinicial    as int.

hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.

vlinha = ttentrada.linha.
vqtd = ttentrada.qtd.


IF ttentrada.etbcod <> ? THEN DO:
    open query q-leitura for each estab where estab.etbcod = ttentrada.etbcod NO-LOCK.
END.
ELSE DO:
    open query q-leitura for each estab no-lock by estab.tipoloja by estab.munic by estab.etbcod.
END.

if vlinha = ? or vlinha = 0 then vlinha = 1.

if ttentrada.botao = "prev"
then do:
    vlinha = vlinha - vqtd - vqtd .
    if vlinha > 0
    then do:
        reposition q-leitura to row vlinha no-error.
    end.
    else do:
        vlinha = 1.
    end.
    vinicial = vlinha.
end.
else do:
    if vlinha > 1
    then do:
        reposition q-leitura to row vlinha no-error.
    end.
    vinicial = vlinha.
end.

REPEAT:
    get next q-leitura.
    if not avail estab then do:
        vlinha = ?.
        leave.
    end.

    FIND supervisor WHERE supervisor.supcod = estab.supcod NO-LOCK NO-ERROR.
    IF avail supervisor THEN
        vsupnom = supervisor.supnom.
    ELSE
        vsupnom = "".

    CREATE ttestab.
    ttestab.etbcod = estab.etbcod.
    ttestab.etbnom = estab.tipoloja + " " + estab.etbnom.
    ttestab.munic = estab.munic.
    ttestab.supcod = estab.supcod.
    ttestab.supnom = vsupnom.

    vlinha = vlinha + 1.
    vqtd = vqtd - 1.
    if vqtd <= 0 then leave.
END.


create tttotal.
tttotal.linha = vinicial.

/* procura total*/
if ttentrada.linha = ? and ttentrada.etbcod = ? 
then do:
    def var qtdtotal as int.

    reposition q-leitura to row 1 no-error.

    REPEAT:
        get next q-leitura. 
        if not avail estab then do:
            leave.
        end.

        qtdtotal = qtdtotal + 1.
    END.
    tttotal.qtdRegistros = string(qtdtotal).
end.


find first ttestab no-error.
if not avail ttestab
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.retorno = "estab nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.
    

hsaida  = dataset conteudoSaida:handle.


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


