<?php

namespace MrPrompt\Cielo\Enum\Status;

use MrPrompt\Cielo\Exceptions\ValidacaoErrors;

enum Retorno: string {
    case UNKNOWN_STATUS = '99';
    case INTERNAL_ERROR = '0';
    case MERCHANT_ID_IS_REQUIRED = '101';
    case PAYMENT_TYPE_IS_REQUIRED = '102';
    case PAYMENT_TYPE_CAN_ONLY_CONTAIN_LETTERS = '103';
    case CUSTOMER_IDENTITY_IS_REQUIRED = '104';
    case CUSTOMER_NAME_IS_REQUIRED = '105';
    case TRANSACTION_ID_IS_REQUIRED = '106';
    case ORDER_ID_IS_INVALID_OR_DOES_NOT_EXIST = '107';
    case AMOUNT_MUST_BE_GREATER_OR_EQUAL_TO_ZERO = '108';
    case PAYMENT_CURRENCY_IS_REQUIRED = '109';
    case INVALID_PAYMENT_CURRENCY = '110';
    case PAYMENT_COUNTRY_IS_REQUIRED = '111';
    case INVALID_PAYMENT_COUNTRY = '112';
    case INVALID_PAYMENT_CODE = '113';
    case MERCHANT_ID_NOT_IN_CORRECT_FORMAT = '114';
    case MERCHANT_ID_NOT_FOUND = '115';
    case MERCHANT_ID_IS_BLOCKED = '116';
    case CREDIT_CARD_HOLDER_IS_REQUIRED = '117';
    case CREDIT_CARD_NUMBER_IS_REQUIRED = '118';
    case AT_LEAST_ONE_PAYMENT_IS_REQUIRED = '119';
    case REQUEST_IP_NOT_ALLOWED = '120';
    case CUSTOMER_IS_REQUIRED = '121';
    case MERCHANT_ORDER_ID_IS_REQUIRED = '122';
    case INSTALLMENTS_MUST_BE_GREATER_OR_EQUAL_TO_ONE = '123';
    case CREDIT_CARD_IS_REQUIRED = '124';
    case CREDIT_CARD_EXPIRATION_DATE_IS_REQUIRED = '125';
    case CREDIT_CARD_EXPIRATION_DATE_IS_INVALID = '126';
    case CREDIT_CARD_NUMBER_IS_MANDATORY = '127';
    case CARD_NUMBER_LENGTH_EXCEEDED = '128';
    case AFFILIATION_NOT_FOUND = '129';
    case COULD_NOT_GET_CREDIT_CARD = '130';
    case MERCHANT_KEY_IS_REQUIRED = '131';
    case MERCHANT_KEY_IS_INVALID = '132';
    case PROVIDER_NOT_SUPPORTED_FOR_PAYMENT_TYPE = '133';
    case FINGER_PRINT_LENGTH_EXCEEDED = '134';
    case MERCHANT_DEFINED_FIELD_VALUE_LENGTH_EXCEEDED = '135';
    case ITEM_DATA_NAME_LENGTH_EXCEEDED = '136';
    case ITEM_DATA_SKU_LENGTH_EXCEEDED = '137';
    case PASSENGER_DATA_NAME_LENGTH_EXCEEDED = '138';
    case PASSENGER_DATA_STATUS_LENGTH_EXCEEDED = '139';
    case PASSENGER_DATA_EMAIL_LENGTH_EXCEEDED = '140';
    case PASSENGER_DATA_PHONE_LENGTH_EXCEEDED = '141';
    case TRAVEL_DATA_ROUTE_LENGTH_EXCEEDED = '142';
    case TRAVEL_DATA_JOURNEY_TYPE_LENGTH_EXCEEDED = '143';
    case TRAVEL_LEG_DATA_DESTINATION_LENGTH_EXCEEDED = '144';
    case TRAVEL_LEG_DATA_ORIGIN_LENGTH_EXCEEDED = '145';
    case SECURITY_CODE_LENGTH_EXCEEDED = '146';
    case ADDRESS_STREET_LENGTH_EXCEEDED = '147';
    case ADDRESS_NUMBER_LENGTH_EXCEEDED = '148';
    case ADDRESS_COMPLEMENT_LENGTH_EXCEEDED = '149';
    case ADDRESS_ZIP_CODE_LENGTH_EXCEEDED = '150';
    case ADDRESS_CITY_LENGTH_EXCEEDED = '151';
    case ADDRESS_STATE_LENGTH_EXCEEDED = '152';
    case ADDRESS_COUNTRY_LENGTH_EXCEEDED = '153';
    case ADDRESS_DISTRICT_LENGTH_EXCEEDED = '154';
    case CUSTOMER_NAME_LENGTH_EXCEEDED = '155';
    case CUSTOMER_IDENTITY_LENGTH_EXCEEDED = '156';
    case CUSTOMER_IDENTITY_TYPE_LENGTH_EXCEEDED = '157';
    case CUSTOMER_EMAIL_LENGTH_EXCEEDED = '158';
    case EXTRA_DATA_NAME_LENGTH_EXCEEDED = '159';
    case EXTRA_DATA_VALUE_LENGTH_EXCEEDED = '160';
    case BOLETO_INSTRUCTIONS_LENGTH_EXCEEDED = '161';
    case BOLETO_DEMOSTRATIVE_LENGTH_EXCEEDED = '162';
    case RETURN_URL_IS_REQUIRED = '163';
    case AUTHORIZE_NOW_IS_REQUIRED = '166';
    case ANTIFRAUD_NOT_CONFIGURED = '167';
    case RECURRENT_PAYMENT_NOT_FOUND = '168';
    case RECURRENT_PAYMENT_IS_NOT_ACTIVE = '169';
    case CARTAO_PROTEGIDO_NOT_CONFIGURED = '170';
    case AFFILIATION_DATA_NOT_SENT = '171';
    case CREDENTIAL_CODE_IS_REQUIRED = '172';
    case PAYMENT_METHOD_NOT_ENABLED = '173';
    case CARD_NUMBER_IS_REQUIRED = '174';
    case EAN_IS_REQUIRED = '175';
    case PAYMENT_CURRENCY_NOT_SUPPORTED = '176';
    case CARD_NUMBER_IS_INVALID = '177';
    case EAN_IS_INVALID = '178';
    case MAX_INSTALLMENTS_FOR_RECURRING_PAYMENT_IS_ONE = '179';
    case CARD_PAYMENT_TOKEN_NOT_FOUND = '180';
    case MERCHANT_ID_JUST_CLICK_NOT_CONFIGURED = '181';
    case BRAND_IS_REQUIRED = '182';
    case INVALID_CUSTOMER_BIRTHDATE = '183';
    case REQUEST_COULD_NOT_BE_EMPTY = '184';
    case BRAND_NOT_SUPPORTED_BY_PROVIDER = '185';
    case PROVIDER_DOES_NOT_SUPPORT_OPTIONS = '186';
    case EXTRA_DATA_COLLECTION_CONTAINS_DUPLICATES = '187';
    case AVS_CPF_INVALID = '188';
    case AVS_STREET_LENGTH_EXCEEDED = '189';
    case AVS_NUMBER_LENGTH_EXCEEDED = '190';
    case AVS_DISTRICT_LENGTH_EXCEEDED = '191';
    case AVS_ZIP_CODE_INVALID = '192';
    case SPLIT_AMOUNT_MUST_BE_GREATER_THAN_ZERO = '193';
    case SPLIT_ESTABLISHMENT_IS_REQUIRED = '194';
    case PLATFORM_ID_IS_REQUIRED = '195';
    case DELIVERY_ADDRESS_IS_REQUIRED = '196';
    case STREET_IS_REQUIRED = '197';
    case NUMBER_IS_REQUIRED = '198';
    case ZIP_CODE_IS_REQUIRED = '199';
    case CITY_IS_REQUIRED = '200';
    case STATE_IS_REQUIRED = '201';
    case DISTRICT_IS_REQUIRED = '202';
    case CART_ITEM_NAME_IS_REQUIRED = '203';
    case CART_ITEM_QUANTITY_IS_REQUIRED = '204';
    case CART_ITEM_TYPE_IS_REQUIRED = '205';
    case CART_ITEM_NAME_LENGTH_EXCEEDED = '206';
    case CART_ITEM_DESCRIPTION_LENGTH_EXCEEDED = '207';
    case CART_ITEM_SKU_LENGTH_EXCEEDED = '208';
    case SHIPPING_ADDRESSEE_SKU_LENGTH_EXCEEDED = '209';
    case SHIPPING_DATA_CANNOT_BE_NULL = '210';
    case WALLET_KEY_IS_INVALID = '211';
    case MERCHANT_WALLET_CONFIGURATION_NOT_FOUND = '212';
    case CREDIT_CARD_NUMBER_IS_INVALID = '213';
    case CREDIT_CARD_HOLDER_MUST_HAVE_ONLY_LETTERS = '214';
    case AGENCY_IS_REQUIRED_IN_BOLETO_CREDENTIAL = '215';
    case CUSTOMER_IP_ADDRESS_IS_INVALID = '216';
    case MERCHANT_ID_NOT_FOUND_300 = '300';
    case REQUEST_IP_NOT_ALLOWED_301 = '301';
    case SENT_MERCHANT_ORDER_ID_IS_DUPLICATED = '302';
    case SENT_ORDER_ID_DOES_NOT_EXIST = '303';
    case CUSTOMER_IDENTITY_IS_REQUIRED_304 = '304';
    case MERCHANT_IS_BLOCKED = '306';
    case TRANSACTION_NOT_FOUND = '307';
    case TRANSACTION_NOT_AVAILABLE_TO_CAPTURE = '308';
    case TRANSACTION_NOT_AVAILABLE_TO_VOID = '309';
    case PAYMENT_METHOD_DOES_NOT_SUPPORT_OPERATION = '310';
    case REFUND_NOT_ENABLED_FOR_MERCHANT = '311';
    case TRANSACTION_NOT_AVAILABLE_TO_REFUND = '312';
    case RECURRENT_PAYMENT_NOT_FOUND_313 = '313';
    case INVALID_INTEGRATION = '314';
    case CANNOT_CHANGE_NEXT_RECURRENCY_WITH_PENDING_PAYMENT = '315';
    case CANNOT_SET_NEXT_RECURRENCY_TO_PAST_DATE = '316';
    case INVALID_RECURRENCY_DAY = '317';
    case NO_TRANSACTION_FOUND = '318';
    case SMART_RECURRENCY_NOT_ENABLED = '319';
    case CANNOT_UPDATE_AFFILIATION_FOR_RECURRENCY = '320';
    case CANNOT_SET_END_DATE_BEFORE_NEXT_RECURRENCY = '321';
    case ZERO_DOLLAR_AUTH_NOT_ENABLED = '322';
    case BIN_QUERY_NOT_ENABLED = '323';

    public static function match(string|int $status): self
    {
        foreach (self::cases() as $case) {
            if ($case->value === (string) $status) {
                return $case;
            }
        }

        return self::match(self::UNKNOWN_STATUS->value);
    }

    public static function retornos(): array
    {
        return array_column(self::cases(), 'name');
    }

    public function descricao(): string
    {
        return match ($this) {
            self::UNKNOWN_STATUS => 'Status desconhecido',
            self::INTERNAL_ERROR => 'Dado enviado excede o tamanho do campo',
            self::MERCHANT_ID_IS_REQUIRED => 'Campo enviado está vazio ou inválido',
            self::PAYMENT_TYPE_IS_REQUIRED => 'Campo enviado está vazio ou inválido',
            self::PAYMENT_TYPE_CAN_ONLY_CONTAIN_LETTERS => 'Caracteres especiais não permitidos',
            self::CUSTOMER_IDENTITY_IS_REQUIRED => 'Campo enviado está vazio ou inválido',
            self::CUSTOMER_NAME_IS_REQUIRED => 'Campo enviado está vazio ou inválido',
            self::TRANSACTION_ID_IS_REQUIRED => 'Campo enviado está vazio ou inválido',
            self::ORDER_ID_IS_INVALID_OR_DOES_NOT_EXIST => 'Campo enviado excede o tamanho ou contem caracteres especiais',
            self::AMOUNT_MUST_BE_GREATER_OR_EQUAL_TO_ZERO => 'Valor da transação deve ser maior que "0"',
            self::PAYMENT_CURRENCY_IS_REQUIRED => 'Campo enviado está vazio ou inválido',
            self::INVALID_PAYMENT_CURRENCY => 'Campo enviado está vazio ou inválido',
            self::PAYMENT_COUNTRY_IS_REQUIRED => 'Campo enviado está vazio ou inválido',
            self::INVALID_PAYMENT_COUNTRY => 'Campo enviado está vazio ou inválido',
            self::INVALID_PAYMENT_CODE => 'Campo enviado está vazio ou inválido',
            self::MERCHANT_ID_NOT_IN_CORRECT_FORMAT => 'O MerchantId enviado não é um GUID',
            self::MERCHANT_ID_NOT_FOUND => 'O MerchantID não existe ou pertence a outro ambiente (EX: Sandbox)',
            self::MERCHANT_ID_IS_BLOCKED => 'Loja bloqueada, entre em contato com o suporte Cielo',
            self::CREDIT_CARD_HOLDER_IS_REQUIRED => 'Campo enviado está vazio ou inválido',
            self::CREDIT_CARD_NUMBER_IS_REQUIRED => 'Campo enviado está vazio ou inválido',
            self::AT_LEAST_ONE_PAYMENT_IS_REQUIRED => 'Nó "Payment" não enviado',
            self::REQUEST_IP_NOT_ALLOWED => 'IP bloqueado por questões de segurança',
            self::CUSTOMER_IS_REQUIRED => 'Nó "Customer" não enviado',
            self::MERCHANT_ORDER_ID_IS_REQUIRED => 'Campo enviado está vazio ou inválido',
            self::INSTALLMENTS_MUST_BE_GREATER_OR_EQUAL_TO_ONE => 'Numero de parcelas deve ser superior a 1',
            self::CREDIT_CARD_IS_REQUIRED => 'Campo enviado está vazio ou inválido',
            self::CREDIT_CARD_EXPIRATION_DATE_IS_REQUIRED => 'Campo enviado está vazio ou inválido',
            self::CREDIT_CARD_EXPIRATION_DATE_IS_INVALID => 'Campo enviado está vazio ou inválido',
            self::CREDIT_CARD_NUMBER_IS_MANDATORY => 'Numero do cartão de crédito é obrigatório',
            self::CARD_NUMBER_LENGTH_EXCEEDED => 'Numero do cartão superiro a 16 digitos',
            self::AFFILIATION_NOT_FOUND => 'Meio de pagamento não vinculado a loja ou Provider inválido',
            self::COULD_NOT_GET_CREDIT_CARD => 'Não é possível encontrar um cartão pelo cardtoken enviado',
            self::MERCHANT_KEY_IS_REQUIRED => 'Campo enviado está vazio ou inválido',
            self::MERCHANT_KEY_IS_INVALID => 'O Merchantkey enviado não é um válido',
            self::PROVIDER_NOT_SUPPORTED_FOR_PAYMENT_TYPE => 'Provider enviado não existe',
            self::FINGER_PRINT_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::MERCHANT_DEFINED_FIELD_VALUE_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::ITEM_DATA_NAME_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::ITEM_DATA_SKU_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::PASSENGER_DATA_NAME_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::PASSENGER_DATA_STATUS_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::PASSENGER_DATA_EMAIL_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::PASSENGER_DATA_PHONE_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::TRAVEL_DATA_ROUTE_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::TRAVEL_DATA_JOURNEY_TYPE_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::TRAVEL_LEG_DATA_DESTINATION_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::TRAVEL_LEG_DATA_ORIGIN_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::SECURITY_CODE_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::ADDRESS_STREET_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::ADDRESS_NUMBER_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::ADDRESS_COMPLEMENT_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::ADDRESS_ZIP_CODE_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::ADDRESS_CITY_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::ADDRESS_STATE_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::ADDRESS_COUNTRY_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::ADDRESS_DISTRICT_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::CUSTOMER_NAME_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::CUSTOMER_IDENTITY_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::CUSTOMER_IDENTITY_TYPE_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::CUSTOMER_EMAIL_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::EXTRA_DATA_NAME_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::EXTRA_DATA_VALUE_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::BOLETO_INSTRUCTIONS_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::BOLETO_DEMOSTRATIVE_LENGTH_EXCEEDED => 'Dado enviado excede o tamanho do campo',
            self::RETURN_URL_IS_REQUIRED => 'URL de retorno não é valida - Não é aceito paginação ou extenções (EX .PHP) na URL de retorno',
            self::AUTHORIZE_NOW_IS_REQUIRED => '***',
            self::ANTIFRAUD_NOT_CONFIGURED => 'Antifraude não vinculado ao cadastro do lojista',
            self::RECURRENT_PAYMENT_NOT_FOUND => 'Recorrência não encontrada',
            self::RECURRENT_PAYMENT_IS_NOT_ACTIVE => 'Recorrência não está ativa. Execução paralizada',
            self::CARTAO_PROTEGIDO_NOT_CONFIGURED => 'Token não vinculado ao cadastro do lojista',
            self::AFFILIATION_DATA_NOT_SENT => 'Falha no processamento do pedido - Entre em contato com o suporte Cielo',
            self::CREDENTIAL_CODE_IS_REQUIRED => 'Falha na validação das credenciadas enviadas',
            self::PAYMENT_METHOD_NOT_ENABLED => 'Meio de pagamento não vinculado ao cadastro do lojista',
            self::CARD_NUMBER_IS_REQUIRED => 'Campo enviado está vazio ou inválido',
            self::EAN_IS_REQUIRED => 'Campo enviado está vazio ou inválido',
            self::PAYMENT_CURRENCY_NOT_SUPPORTED => 'Campo enviado está vazio ou inválido',
            self::CARD_NUMBER_IS_INVALID => 'Campo enviado está vazio ou inválido',
            self::EAN_IS_INVALID => 'Campo enviado está vazio ou inválido',
            self::MAX_INSTALLMENTS_FOR_RECURRING_PAYMENT_IS_ONE => 'Campo enviado está vazio ou inválido',
            self::CARD_PAYMENT_TOKEN_NOT_FOUND => 'Token não encontrado',
            self::MERCHANT_ID_JUST_CLICK_NOT_CONFIGURED => 'Token bloqueado',
            self::BRAND_IS_REQUIRED => 'Bandeira do cartão não enviado',
            self::INVALID_CUSTOMER_BIRTHDATE => 'Data de nascimento inválida ou futura',
            self::REQUEST_COULD_NOT_BE_EMPTY => 'Falha no formado da requisição. Verifique o código enviado',
            self::BRAND_NOT_SUPPORTED_BY_PROVIDER => 'Bandeira não suportada pela API Cielo',
            self::PROVIDER_DOES_NOT_SUPPORT_OPTIONS => 'Meio de pagamento não suporta o comando enviado',
            self::EXTRA_DATA_COLLECTION_CONTAINS_DUPLICATES => '***',
            self::AVS_CPF_INVALID => '',
            self::AVS_STREET_LENGTH_EXCEEDED => '',
            self::AVS_NUMBER_LENGTH_EXCEEDED => '',
            self::AVS_DISTRICT_LENGTH_EXCEEDED => '',
            self::AVS_ZIP_CODE_INVALID => '',
            self::SPLIT_AMOUNT_MUST_BE_GREATER_THAN_ZERO => 'O valor para a realização de Split deve ser maior que 0',
            self::SPLIT_ESTABLISHMENT_IS_REQUIRED => 'Campo enviado está vazio ou inválido',
            self::PLATFORM_ID_IS_REQUIRED => 'Campo enviado está vazio ou inválido',
            self::DELIVERY_ADDRESS_IS_REQUIRED => 'Campo enviado está vazio ou inválido',
            self::STREET_IS_REQUIRED => 'Campo enviado está vazio ou inválido',
            self::NUMBER_IS_REQUIRED => 'Campo enviado está vazio ou inválido',
            self::ZIP_CODE_IS_REQUIRED => 'Campo enviado está vazio ou inválido',
            self::CITY_IS_REQUIRED => 'Campo enviado está vazio ou inválido',
            self::STATE_IS_REQUIRED => 'Campo enviado está vazio ou inválido',
            self::DISTRICT_IS_REQUIRED => 'Campo enviado está vazio ou inválido',
            self::CART_ITEM_NAME_IS_REQUIRED => 'Campo enviado está vazio ou inválido',
            self::CART_ITEM_QUANTITY_IS_REQUIRED => 'Campo enviado está vazio ou inválido',
            self::CART_ITEM_TYPE_IS_REQUIRED => 'Campo enviado está vazio ou inválido',
            self::CART_ITEM_NAME_LENGTH_EXCEEDED => 'Os dados enviados excedem o tamanho do campo',
            self::CART_ITEM_DESCRIPTION_LENGTH_EXCEEDED => 'Os dados enviados excedem o tamanho do campo',
            self::CART_ITEM_SKU_LENGTH_EXCEEDED => 'Os dados enviados excedem o tamanho do campo',
            self::SHIPPING_ADDRESSEE_SKU_LENGTH_EXCEEDED => 'Os dados enviados excedem o tamanho do campo',
            self::SHIPPING_DATA_CANNOT_BE_NULL => 'Campo obrigatório não enviado',
            self::WALLET_KEY_IS_INVALID => 'Dados inválidos do Visa Checkout',
            self::MERCHANT_WALLET_CONFIGURATION_NOT_FOUND => 'A Wallet utilizada não está habilitada, entre em contato com o suporte Cielo para habilitar',
            self::CREDIT_CARD_NUMBER_IS_INVALID => 'O cartão de crédito enviado é inválido',
            self::CREDIT_CARD_HOLDER_MUST_HAVE_ONLY_LETTERS => 'Não deve conter caracteres especiais',
            self::AGENCY_IS_REQUIRED_IN_BOLETO_CREDENTIAL => 'Campo obrigatório não enviado',
            self::CUSTOMER_IP_ADDRESS_IS_INVALID => 'IP bloqueado por motivos de segurança',
            self::MERCHANT_ID_NOT_FOUND_300 => '***',
            self::REQUEST_IP_NOT_ALLOWED_301 => 'O serviço de restrição de IP pode estar habilitado e o IP informado não está configurado. Entre em contato com o suporte para habilitar o IP',
            self::SENT_MERCHANT_ORDER_ID_IS_DUPLICATED => '***',
            self::SENT_ORDER_ID_DOES_NOT_EXIST => '***',
            self::CUSTOMER_IDENTITY_IS_REQUIRED_304 => 'Campo enviado está vazio ou inválido',
            self::MERCHANT_IS_BLOCKED => 'Merchant está bloqueado',
            self::TRANSACTION_NOT_FOUND => 'Transação não encontrada ou não existe no ambiente',
            self::TRANSACTION_NOT_AVAILABLE_TO_CAPTURE => 'Transação não pode ser capturada - Recomendamos consultar o status da transação via API. A captura só pode ser realizada se o status da transação for 1. Cada transação pode ser capturada apenas uma vez, mesmo em casos de captura parcial. Para saber mais, entre em contato com o suporte da Cielo.',
            self::TRANSACTION_NOT_AVAILABLE_TO_VOID => 'Transação não pode ser cancelada - Entre em contato com o suporte da Cielo',
            self::PAYMENT_METHOD_DOES_NOT_SUPPORT_OPERATION => 'Comando enviado não suportado por meios de pagamento',
            self::REFUND_NOT_ENABLED_FOR_MERCHANT => 'Cancelamento após 24 horas não é liberado para o comerciante',
            self::TRANSACTION_NOT_AVAILABLE_TO_REFUND => 'A transação não permite cancelamento após 24 horas',
            self::RECURRENT_PAYMENT_NOT_FOUND_313 => 'Recorrência não está habilitada, entre em contato com o suporte Cielo para habilitar',
            self::INVALID_INTEGRATION => '***',
            self::CANNOT_CHANGE_NEXT_RECURRENCY_WITH_PENDING_PAYMENT => '***',
            self::CANNOT_SET_NEXT_RECURRENCY_TO_PAST_DATE => 'Não é permitido alterar a data de recorrência para uma data passada',
            self::INVALID_RECURRENCY_DAY => '***',
            self::NO_TRANSACTION_FOUND => '***',
            self::SMART_RECURRENCY_NOT_ENABLED => 'Recorrência não vinculada ao cadastro do comerciante',
            self::CANNOT_UPDATE_AFFILIATION_FOR_RECURRENCY => '***',
            self::CANNOT_SET_END_DATE_BEFORE_NEXT_RECURRENCY => '***',
            self::ZERO_DOLLAR_AUTH_NOT_ENABLED => 'O Zero Auth não está habilitado, entre em contato com o suporte Cielo para habilitar',
            self::BIN_QUERY_NOT_ENABLED => 'A Consulta Bin não está habilitada, entre em contato com o suporte Cielo para habilitar',
        };
    }
}
