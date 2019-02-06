/*==============================================================*/
/* DBMS name:      PostgreSQL 8                                 */
/* Created on:     22/10/2018 3:28:14                           */
/*==============================================================*/


drop index DIRECCIONES_PK;

drop table DIRECCIONES;

drop index DISTANCIA_PK;

drop table DISTANCIA;

/*==============================================================*/
/* Table: DIRECCIONES                                           */
/*==============================================================*/
create table DIRECCIONES (
   ID_DIR               SERIAL                 not null,
   LATITUDE             VARCHAR(256)         null,
   LONGITUDE            VARCHAR(256)         null,
   FECHA_BUSQ           DATE                 null,
   constraint PK_DIRECCIONES primary key (ID_DIR)
);

/*==============================================================*/
/* Index: DIRECCIONES_PK                                        */
/*==============================================================*/
create unique index DIRECCIONES_PK on DIRECCIONES (
ID_DIR
);

/*==============================================================*/
/* Table: DISTANCIA                                             */
/*==============================================================*/
create table DISTANCIA (
   ID                   SERIAL                 not null,
   INICIO               VARCHAR(512)         null,
   DESTINO              VARCHAR(512)         null,
   KM                   VARCHAR(128)         null,
   ESTIMADO             VARCHAR(256)         null,
   TREAL                 VARCHAR(256)         null,
   FECHA                timestamp without time zone                 null,
   constraint PK_DISTANCIA primary key (ID)
);

/*==============================================================*/
/* Index: DISTANCIA_PK                                          */
/*==============================================================*/
create unique index DISTANCIA_PK on DISTANCIA (
ID
);

