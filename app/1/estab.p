def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */


def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field etbcod  like estab.etbcod
    field recatu  AS recid
    field acao  AS char.

def temp-table ttestab  no-undo serialize-name "estab"  /* JSON SAIDA */
    FIELD etbcod like estab.etbcod
    FIELD etbnom like estab.etbnom
    FIELD munic like estab.munic
    FIELD supcod like estab.supcod
    FIELD supnom LIKE supervisor.supnom
    FIELD recatu  AS recid 
    index estab is unique primary etbcod asc.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field retorno      as char.

def var vsupnom   as char.

def query q-leitura for estab scrolling.
def var vrecatu as recid.
def var vqtd as int.

hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.

vrecatu = ttentrada.recatu.
vqtd = 10.

IF ttentrada.etbcod <> ? THEN DO:
    find estab where estab.etbcod = ttentrada.etbcod NO-LOCK NO-ERROR.
    IF avail estab THEN DO:
        FIND supervisor WHERE supervisor.supcod = estab.supcod NO-LOCK NO-ERROR.
        IF avail supervisor THEN
            vsupnom = supervisor.supnom.
        ELSE
            vsupnom = "".
        CREATE ttestab.
        ttestab.etbcod = estab.etbcod.
        ttestab.etbnom = estab.etbnom.
        ttestab.munic = estab.munic.
        ttestab.supcod = estab.supcod.
        ttestab.supnom = vsupnom.
        ttestab.recatu = recid(estab).
    END.
END.
ELSE DO:
    open query q-leitura for each estab where estab.etbcod no-lock.

    IF vrecatu <> ? THEN DO:
        reposition q-leitura to recid vrecatu no-error.
        get next  q-leitura.  
        if not avail estab
        then do:
            vrecatu = ?.
            return.
        end.
    END.

    REPEAT:
        IF ttentrada.acao = "prev" THEN
            get prev  q-leitura. 
        ELSE
            get next  q-leitura. 

        IF NOT AVAIL estab THEN LEAVE.

        FIND supervisor WHERE supervisor.supcod = estab.supcod NO-LOCK NO-ERROR.
        IF avail supervisor THEN
            vsupnom = supervisor.supnom.
        ELSE
            vsupnom = "".

        CREATE ttestab.
        ttestab.etbcod = estab.etbcod.
        ttestab.etbnom = estab.etbnom.
        ttestab.munic = estab.munic.
        ttestab.supcod = estab.supcod.
        ttestab.supnom = vsupnom.
        ttestab.recatu = recid(estab).

        vqtd = vqtd - 1.
        IF vqtd <= 0 THEN LEAVE.

    END.
END.

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

hsaida  = TEMP-TABLE ttestab:handle.


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


