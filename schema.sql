DROP TABLE IF EXISTS `Address`;
DROP TABLE IF EXISTS `Delivery`;
DROP TABLE IF EXISTS `Discount`;
DROP TABLE IF EXISTS `Invoice`;
DROP TABLE IF EXISTS `InvoiceLine`;
DROP TABLE IF EXISTS `Issuer`;
DROP TABLE IF EXISTS `Payment`;
DROP TABLE IF EXISTS `Receiver`;
DROP TABLE IF EXISTS `TaxTotal`;
DROP TABLE IF EXISTS `TaxableItem`;
DROP TABLE IF EXISTS `Value`;
DROP TABLE IF EXISTS `Item`;
DROP TABLE IF EXISTS ETAItems;
DROP TABLE IF EXISTS ETAInvoices;

create table Address (
    Id int AUTO_INCREMENT NOT NULL,
    branchID varchar(50) NULL,
    country varchar(50) NULL,
    governate varchar(50) NULL,
    regionCity varchar(50) NULL,
    street varchar(50) NULL,
    buildingNumber varchar(50) NULL,
    postalCode varchar(50) NULL,
    floor varchar(50) NULL,
    room varchar(50) NULL,
    landmark varchar(50) NULL,
    additionalInformation varchar(50) NULL,
	`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
CONSTRAINT PK_Address PRIMARY KEY CLUSTERED
   (
      Id asc
   )
)
;
create table Issuer (
    Id int AUTO_INCREMENT NOT NULL,
    address_id int,
    type varchar(50) NULL,
    issuer_id varchar(50) NULL,
    name varchar(50) NULL,
	`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
CONSTRAINT PK_Issuer PRIMARY KEY CLUSTERED
   (
      Id asc
   )
)
;

create table Receiver (
    Id int AUTO_INCREMENT NOT NULL,
    address_id int,
    type varchar(50) NULL,
    receiver_id varchar(50) NULL,
    name varchar(50) NULL,
	`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
CONSTRAINT PK_Receiver PRIMARY KEY CLUSTERED
   (
      Id asc
   )
)
;

create table Payment (
    Id int AUTO_INCREMENT NOT NULL,
    bankName varchar(50) NULL,
    bankAddress varchar(50) NULL,
    bankAccountNo varchar(50) NULL,
    bankAccountIBAN varchar(50) NULL,
    swiftCode varchar(50) NULL,
    terms varchar(50) NULL,
	`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
CONSTRAINT PK_Payment PRIMARY KEY CLUSTERED
   (
      Id asc
   )
)
;
create table Delivery (
    Id int AUTO_INCREMENT NOT NULL,
    approach varchar(50) NULL,
    packaging varchar(50) NULL,
    dateValidity datetime,
    exportPort varchar(50) NULL,
    grossWeight decimal(9,2) NOT NULL,
    netWeight decimal(9,2) NOT NULL,
    terms varchar(50) NULL,
	`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
CONSTRAINT PK_Delivery PRIMARY KEY CLUSTERED
   (
      Id asc
   )
)
;
create table Value (
    Id int AUTO_INCREMENT NOT NULL,	
    currencySold varchar(5) NULL,
    amountEGP decimal(9,3),
	amountSold decimal(9,3) NULL,
	currencyExchangeRate decimal(9,3) NULL,
	`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
CONSTRAINT PK_UnitValue PRIMARY KEY CLUSTERED
   (
      Id asc
   )
)
;
create table Discount (
    Id int AUTO_INCREMENT NOT NULL,
    rate decimal(9,3) NOT NULL,
    amount decimal(9.3) NOT NULL,
	`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
CONSTRAINT PK_Discount PRIMARY KEY CLUSTERED
   (
      Id asc
   )
)
;
create table InvoiceLine (
    Id int AUTO_INCREMENT NOT NULL,
    description varchar(50) NULL,
    itemType varchar(50) NULL,
    itemCode varchar(50) NULL,
    unitType varchar(50) NULL,
    quantity int NOT NULL,
    internalCode varchar(50) NULL,
    salesTotal decimal(9,3),
    total decimal(9,3),
    valueDifference decimal(9,3) NOT NULL,
    totalTaxableFees decimal(9,3) NOT NULL,
    netTotal decimal(9,3),
    itemsDiscount decimal(9,3) NOT NULL,
    unitValue_id int,
    discount_id int,
	invoice_id int not null,
	`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
CONSTRAINT PK_InvoiceLine PRIMARY KEY CLUSTERED
   (
      Id asc
   )
)
;

create table TaxableItem (
    Id int AUTO_INCREMENT NOT NULL,
    taxType varchar(50) NULL,
    amount decimal(9,3) NOT NULL,
    subType varchar(50) NULL,
    rate decimal(9,3) NOT NULL,
	invoiceline_id int NOT NULL,
	`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
CONSTRAINT PK_TaxableItem PRIMARY KEY CLUSTERED
   (
      Id asc
   )
)
;
create table TaxTotal (
    Id int AUTO_INCREMENT NOT NULL,
    taxType varchar(50) NULL,
    amount decimal(9,3) NOT NULL,
	invoice_id int not null,
	`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
CONSTRAINT PK_TaxTotal PRIMARY KEY CLUSTERED
   (
      Id asc
   )
)
;
;
create table Invoice (
    Id int AUTO_INCREMENT NOT NULL,
    issuer_id int,
    receiver_id int,
    documentType varchar(50) NULL,
    documentTypeVersion varchar(50) NULL,
    dateTimeIssued datetime,
    taxpayerActivityCode varchar(50) NULL,
    internalID varchar(50) NULL,
    purchaseOrderReference varchar(50) NULL,
    purchaseOrderDescription varchar(50) NULL,
    salesOrderReference varchar(50) NULL,
    salesOrderDescription varchar(50) NULL,
    proformaInvoiceNumber varchar(50) NULL,
    payment_id int,
    delivery_id int,
    totalDiscountAmount decimal(9,3) NOT NULL,
    totalSalesAmount decimal(9,3) NOT NULL,
    netAmount decimal(9,3) NOT NULL,
    totalAmount decimal(9,3) NOT NULL,
    extraDiscountAmount decimal(9,3) NOT NULL,
    totalItemsDiscountAmount decimal(9,3) NOT NULL,
    uuid                          VARCHAR(26) NULL,
    submissionUUID                VARCHAR(26) NULL,
    longId                        VARCHAR(80) NULL,
  	createdByUserId               VARCHAR(46) NULL,
	upload_id	int NULL,
    `status` VARCHAR(200) NULL DEFAULT NULL,
	`statusReason` VARCHAR(1000) NULL DEFAULT NULL,
	`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
CONSTRAINT PK_Invoice PRIMARY KEY CLUSTERED
   (
      Id asc
   )
)
;
create table Item (
    Id int AUTO_INCREMENT NOT NULL,
    codeType varchar(50) NULL,
    parentCode varchar(50) NULL,
    itemCode varchar(50) NOT NULL,
    codeName varchar(50) NULL,
    codeNameAr varchar(50) NULL,
    activeFrom datetime,
    activeTo datetime,
    description varchar(50) NULL,
    descriptionAr varchar(50) NULL,
    requestReason varchar(50) NULL,
	`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT PK_Item PRIMARY KEY CLUSTERED
    (
      Id asc
    ),
	CONSTRAINT CODE_ITEM_IDX UNIQUE INDEX (itemCode)
)
;
CREATE TABLE ETAItems(
  Id int AUTO_INCREMENT NOT NULL
  ,codeUsageRequestID               INTEGER   
  ,codeTypeName                     VARCHAR(3) 
  ,codeID                           INTEGER  
  ,itemCode                         VARCHAR(250) 
  ,codeNamePrimaryLang              VARCHAR(250) 
  ,codeNameSecondaryLang            VARCHAR(250) 
  ,descriptionPrimaryLang           VARCHAR(250) 
  ,descriptionSecondaryLang         VARCHAR(250) 
  ,parentCodeID                     INTEGER  
  ,parentItemCode                   INTEGER  
  ,parentCodeNamePrimaryLang        VARCHAR(250) 
  ,parentCodeNameSecondaryLang      VARCHAR(250) 
  ,parentLevelName                  VARCHAR(250) 
  ,levelName                        VARCHAR(250) 
  ,requestCreationDateTimeUtc       datetime
  ,codeCreationDateTimeUtc          datetime
  ,activeFrom                       datetime
  ,activeTo                         datetime
  ,active                           boolean
  ,status                           VARCHAR(100) 
  ,statusReason                     VARCHAR(300)
  ,ownerTaxpayerrin                 INTEGER  
  ,ownerTaxpayername                VARCHAR(250) 
  ,ownerTaxpayernameAr              VARCHAR(250) 
  ,requesterTaxpayerrin             INTEGER  
  ,requesterTaxpayername            VARCHAR(250) 
  ,requesterTaxpayernameAr          VARCHAR(250) 
  ,codeCategorizationlevel1id       INTEGER  
  ,codeCategorizationlevel1name     VARCHAR(250) 
  ,codeCategorizationlevel1nameAr   VARCHAR(250) 
  ,codeCategorizationlevel2id       INTEGER  
  ,codeCategorizationlevel2name     VARCHAR(250) 
  ,codeCategorizationlevel2nameAr   VARCHAR(250) 
  ,codeCategorizationlevel3id       INTEGER  
  ,codeCategorizationlevel3name     VARCHAR(250) 
  ,codeCategorizationlevel3nameAr   VARCHAR(250) 
  ,codeCategorizationlevel4id       INTEGER  
  ,codeCategorizationlevel4name     VARCHAR(250) 
  ,codeCategorizationlevel4nameAr   VARCHAR(250) 
  ,CONSTRAINT PK_ETAItem PRIMARY KEY CLUSTERED
  (
    Id asc
  )
)
;
CREATE TABLE ETAInvoices(
  Id int AUTO_INCREMENT NOT NULL
  ,uuid                          VARCHAR(26) NOT NULL
  ,submissionUUID                VARCHAR(26) NOT NULL
  ,longId                        VARCHAR(80) NOT NULL
  ,internalId                    VARCHAR(32) NOT NULL
  ,typeName                      VARCHAR(10) NOT NULL
  ,typeVersionName               NUMERIC(5,2) NOT NULL
  ,issuerId                      INTEGER  NOT NULL
  ,issuerName                    VARCHAR(256) NOT NULL
  ,receiverId                    INTEGER  NULL
  ,receiverName                  VARCHAR(256) NULL
  ,dateTimeIssued                DATETIME  NOT NULL
  ,dateTimeReceived              DATETIME  NOT NULL
  ,totalSales                    NUMERIC(12,2) NOT NULL
  ,totalDiscount                 NUMERIC(12,2) NOT NULL
  ,netAmount                     NUMERIC(12,2) NOT NULL
  ,total                         NUMERIC(12,2) NOT NULL
  ,cancelRequestDate             DATETIME NULL 
  ,rejectRequestDate             DATETIME NULL
  ,cancelRequestDelayedDate      DATETIME NULL
  ,rejectRequestDelayedDate      DATETIME NULL
  ,declineCancelRequestDate      DATETIME NULL
  ,declineRejectRequestDate      DATETIME NULL
  ,status                        VARCHAR(16) NOT NULL
  ,createdByUserId               VARCHAR(46) NOT NULL
  ,CONSTRAINT PK_ETAInvoices PRIMARY KEY CLUSTERED
  (
    Id asc
  )
);
CREATE TABLE Uploads (
	Id int AUTO_INCREMENT NOT NULL,
    userId INT NOT NULL,
    fileName VARCHAR(255) NOT NULL,
    recordsCount INT NOT NULL,
    status VARCHAR(100) NOT NULL,
	`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT PK_Uploads PRIMARY KEY CLUSTERED
	(
    	Id asc
  	)
);
ALTER TABLE Invoice ADD CONSTRAINT fk_invoice_issuer_id FOREIGN KEY (issuer_id) REFERENCES Issuer(id);
ALTER TABLE Invoice ADD CONSTRAINT fk_invoice_receiver_id FOREIGN KEY (receiver_id) REFERENCES Receiver(id);
ALTER TABLE Invoice ADD CONSTRAINT fk_invoice_payment_id FOREIGN KEY (payment_id) REFERENCES Payment(id);
ALTER TABLE Invoice ADD CONSTRAINT fk_invoice_delivery_id FOREIGN KEY (delivery_id) REFERENCES Delivery(id);
ALTER TABLE Issuer ADD CONSTRAINT fk_issuer_address_id FOREIGN KEY (address_id) REFERENCES Address(id);
ALTER TABLE TaxTotal ADD CONSTRAINT fk_TaxTotal_invoice_id FOREIGN KEY (invoice_id) REFERENCES Invoice(id);
ALTER TABLE TaxableItem ADD CONSTRAINT fk_TaxableItem_invoiceline_id FOREIGN KEY (invoiceline_id) REFERENCES InvoiceLine(id);
ALTER TABLE InvoiceLine ADD CONSTRAINT fk_invoiceline_unitvalue_id FOREIGN KEY (unitValue_id) REFERENCES Value(id);
ALTER TABLE InvoiceLine ADD CONSTRAINT fk_invoiceline_discount_it FOREIGN KEY (discount_id) REFERENCES Discount(id);
ALTER TABLE InvoiceLine ADD CONSTRAINT fk_invoiceline_invoice_id FOREIGN KEY (invoice_id) REFERENCES Invoice(id);
ALTER TABLE Receiver ADD CONSTRAINT fk_receiver_address_id FOREIGN KEY (address_id) REFERENCES Address(id);


ALTER TABLE `ETAInvoices` CHANGE `receiverId` `receiverId` BIGINT(14) NULL DEFAULT NULL;


CREATE TABLE `doctors` (
  `id` int(11) AUTO_INCREMENT NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `another_phone` varchar(255) DEFAULT NULL,
  `specialty` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  CONSTRAINT PK_doctors PRIMARY KEY CLUSTERED
	(
    	id asc
  	)
);

CREATE TABLE `patients` (
  `id` int(11) AUTO_INCREMENT NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `insurance_number` varchar(255) DEFAULT NULL,
  `insurance_company` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  CONSTRAINT PK_patients PRIMARY KEY CLUSTERED
	(
    	id asc
  	)
);

CREATE TABLE `clinics` (
  `id` int(11) AUTO_INCREMENT NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  CONSTRAINT PK_clinics PRIMARY KEY CLUSTERED
	(
    	id asc
  	)
);


CREATE TABLE `rooms` (
  `id` int(11) AUTO_INCREMENT NOT NULL,
  `name` varchar(255) NOT NULL,
  `clinic_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  CONSTRAINT PK_rooms PRIMARY KEY CLUSTERED
	(
    	id asc
  	)
);

CREATE TABLE `drugs` (
  `id` int(11) AUTO_INCREMENT NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  CONSTRAINT PK_drugs PRIMARY KEY CLUSTERED
	(
    	id asc
  	)
);

CREATE TABLE `appointments` (
  `id` int(11) AUTO_INCREMENT NOT NULL,
  `date` date NOT NULL,
  `from` datetime NOT NULL,
  `to` datetime NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `room_id` int(11) DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  CONSTRAINT PK_appointments PRIMARY KEY CLUSTERED
	(
    	id asc
  	)
);

CREATE TABLE `prescriptions` (
  `id` int(11) AUTO_INCREMENT NOT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `patient_id` int(11) NOT NULL,
  `dateTimeIssued` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  CONSTRAINT PK_prescriptions PRIMARY KEY CLUSTERED
	(
    	id asc
  	)
);


CREATE TABLE `prescription_items` (
  `id` int(11) AUTO_INCREMENT NOT NULL,
  `prescription_id` int(11) NOT NULL,
  `drug_id` int(11) NOT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  CONSTRAINT PK_prescription_items PRIMARY KEY CLUSTERED
	(
    	id asc
  	)
);