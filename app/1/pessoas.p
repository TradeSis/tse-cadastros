def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field cpfCnpj  like pessoas.cpfCnpj
    field idPessoa  like pessoas.idPessoa.

def temp-table ttpessoas  no-undo serialize-name "pessoas"  /* JSON SAIDA */
    like pessoas
    FIELD tipoPessoa       like geralpessoas.tipoPessoa
    FIELD nomePessoa       like geralpessoas.nomePessoa
    FIELD nomeFantasia     like geralpessoas.nomeFantasia
    FIELD IE               like geralpessoas.IE
    FIELD codigoCidade     like geralpessoas.codigoCidade
    FIELD codigoEstado     like geralpessoas.codigoEstado
    FIELD pais             like geralpessoas.pais
    FIELD bairro           like geralpessoas.bairro
    FIELD endereco         like geralpessoas.endereco
    FIELD endNumero        like geralpessoas.endNumero
    FIELD cep              like geralpessoas.cep
    FIELD municipio        like geralpessoas.municipio
    FIELD email            like geralpessoas.email
    FIELD telefone         like geralpessoas.telefone
    FIELD crt              like geralpessoas.crt
    FIELD regimeTrib       like geralpessoas.regimeTrib
    FIELD cnae             like geralpessoas.cnae
    FIELD regimeEspecial   like geralpessoas.regimeEspecial
    FIELD caracTrib        like geralpessoas.caracTrib.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field descricaoStatus      as char.

def VAR vidPessoa like ttentrada.idPessoa.


hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.

vidPessoa = 0.
if avail ttentrada
then do:
    vidPessoa = ttentrada.idPessoa.
    if vidPessoa = ? then vidPessoa = 0.
end.
if ttentrada.cpfCnpj = ""
then do:
    ttentrada.cpfCnpj = ?.
end.
if ttentrada.idPessoa = 0
then do:
    ttentrada.idPessoa = ?.
end.

IF ttentrada.idPessoa <> ? OR (ttentrada.idPessoa = ? AND ttentrada.cpfCnpj = ?)
THEN DO:
    for each pessoas where
        (if vidPessoa = 0
        then true /* TODOS */
        ELSE pessoas.idPessoa = vidPessoa)
        no-lock.

        
        RUN criaPessoas.

    end.
END.

IF ttentrada.cpfCnpj <> ?
THEN DO:

    find pessoas where 
        pessoas.cpfCnpj =  ttentrada.cpfCnpj 
        NO-LOCK no-error.
        
        if avail pessoas
        then do:
            RUN criaPessoas.
        end.
END.


find first ttpessoas no-error.

if not avail ttpessoas
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Pessoa nao encontrada".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttpessoas:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).


PROCEDURE criaPessoas.

        FIND geralpessoas OF pessoas NO-LOCK NO-ERROR.
        IF NOT AVAIL geralpessoas THEN NEXT.
        
        create ttpessoas.
        ttpessoas.idPessoa = pessoas.idPessoa.
        ttpessoas.cpfCnpj = pessoas.cpfCnpj.
        ttpessoas.tipoPessoa = geralpessoas.tipoPessoa.
        ttpessoas.nomePessoa = geralpessoas.nomePessoa.
        ttpessoas.nomeFantasia = geralpessoas.nomeFantasia.
        ttpessoas.IE = geralpessoas.IE.
        ttpessoas.codigoCidade = geralpessoas.codigoCidade.
        ttpessoas.codigoEstado = geralpessoas.codigoEstado.
        ttpessoas.pais = geralpessoas.pais.
        ttpessoas.bairro = geralpessoas.bairro.
        ttpessoas.endereco = geralpessoas.endereco.
        ttpessoas.endNumero = geralpessoas.endNumero.
        ttpessoas.cep = geralpessoas.cep.
        ttpessoas.municipio = geralpessoas.municipio.
        ttpessoas.email = geralpessoas.email.
        ttpessoas.telefone = geralpessoas.telefone.
        ttpessoas.crt = geralpessoas.crt.
        ttpessoas.regimeTrib = geralpessoas.regimeTrib.
        ttpessoas.cnae = geralpessoas.cnae.
        ttpessoas.regimeEspecial = geralpessoas.regimeEspecial.
        ttpessoas.caracTrib = geralpessoas.caracTrib.

END.
