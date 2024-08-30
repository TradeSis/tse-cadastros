def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */


def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field etbcod  like estab.etbcod
    field pagina  AS INT.

def temp-table ttestab  no-undo serialize-name "estab"  /* JSON SAIDA */
    FIELD etbcod like estab.etbcod
    FIELD etbnom like estab.etbnom
    FIELD munic like estab.munic
    FIELD supcod like estab.supcod
    FIELD supnom LIKE supervisor.supnom.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field retorno      as char.

DEF VAR contador AS INT.
DEF VAR varPagina AS INT.
def var vsupnom   as char.

hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.

contador = 0.
varPagina = ttentrada.pagina + 10.

IF ttentrada.etbcod <> ?
then do:
    find estab where estab.etbcod = ttentrada.etbcod NO-LOCK NO-ERROR.
    if avail estab
    then do:
        find supervisor where supervisor.supcod = estab.supcod no-lock no-error.
        if avail supervisor
        then do:
            vsupnom = supervisor.supnom.
        end.
        ELSE DO:
        vsupnom = "".
        END.
        create ttestab.
        ttestab.etbcod    = estab.etbcod.
        ttestab.etbnom   = estab.etbnom.
        ttestab.munic   = estab.munic.
        ttestab.supcod   = estab.supcod.
        ttestab.supnom   = vsupnom.
    end.
end. 
ELSE DO:
    for each estab no-lock.
         
         contador = contador + 1.
        IF contador > ttentrada.pagina and contador <= varPagina THEN DO:
            find supervisor where supervisor.supcod = estab.supcod no-lock no-error.
            if avail supervisor
            then do:
                vsupnom = supervisor.supnom.
            end.
            ELSE DO:
               vsupnom = "".
            END.
            create ttestab.
            ttestab.etbcod    = estab.etbcod.
            ttestab.etbnom   = estab.etbnom.
            ttestab.munic   = estab.munic.
            ttestab.supcod   = estab.supcod.
            ttestab.supnom   = vsupnom.  
            
        end.
    end.
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


