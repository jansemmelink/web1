mysql -uroot -p
CREATE DATABASE entryform;
GRANT ALL PRIVILEGES ON entryform.* TO 'entryform_web'@'localhost' IDENTIFIED BY 'ef$web' WITH GRANT OPTION;

mysql -uentryform_web -p entryform
> password...

create table user (
    id char(15) NOT NULL PRIMARY KEY,
    name char(63) NOT NULL,
    surname char(63) NOT NULL,
    email char(127) NOT NULL,
    telephone char(31) NOT NULL,
    account char(31),
    pwsha1 char(63) NOT NULL
);

#-------------------------------------------------------
# organisations
#-------------------------------------------------------
create table org (
    id char(15) NOT NULL PRIMARY KEY,
    parent_id char(15) NOT NULL,
    name char(63) NOT NULL,
    email char(127) NOT NULL,
    telephone char(127) NOT NULL
);

insert into org set id="phaiqu6Hohgo2Wi",parent_id="",name="Die Voortrekkers",email="info@voortrekkers.org.za",telephone="";
insert into org set id="ahhie6Xixaule5I",parent_id="phaiqu6Hohgo2Wi",name="Midstream Voortrekkers",email="midstream.voortrekkers@gmail.com",telephone="";

create table org_group (
    id char(15) NOT NULL PRIMARY KEY,
    org_id char(15) NOT NULL,
    name char(63) NOT NULL
);

insert into org_group set id="Oofioj1Eikei4ph",org_id="ahhie6Xixaule5I",name="Graad  R";
insert into org_group set id="Iqua2aungooHee6",org_id="ahhie6Xixaule5I",name="Graad  1";
insert into org_group set id="heiHiemie8izaj6",org_id="ahhie6Xixaule5I",name="Graad  2";
insert into org_group set id="eeLieD0eif1Thah",org_id="ahhie6Xixaule5I",name="Graad  3";
insert into org_group set id="ahghoo9eevoWoev",org_id="ahhie6Xixaule5I",name="Graad  4";
insert into org_group set id="bel9Weibebohng4",org_id="ahhie6Xixaule5I",name="Graad  5";
insert into org_group set id="Oov6eiz4choQuah",org_id="ahhie6Xixaule5I",name="Graad  6";
insert into org_group set id="ahyieDai0Aeshu0",org_id="ahhie6Xixaule5I",name="Graad  7";
insert into org_group set id="eiRae8caidoh7vu",org_id="ahhie6Xixaule5I",name="Graad  8";
insert into org_group set id="aeghaibohng2Ooc",org_id="ahhie6Xixaule5I",name="Graad  9";
insert into org_group set id="ohXeiJai2Quohba",org_id="ahhie6Xixaule5I",name="Graad 10";
insert into org_group set id="Xoo3aesae7ooshi",org_id="ahhie6Xixaule5I",name="Graad 11";
insert into org_group set id="ahJ0Re2pahbooQu",org_id="ahhie6Xixaule5I",name="Graad 12";
insert into org_group set id="je8ithuich8veeX",org_id="ahhie6Xixaule5I",name="Staatmaker";
insert into org_group set id="eixohchoh3ahDe0",org_id="ahhie6Xixaule5I",name="Offisier";
insert into org_group set id="choonaenaGhi6ub",org_id="ahhie6Xixaule5I",name="Heemraad";

#-------------------------------------------------------
# list of events
#-------------------------------------------------------
create table event (
    id char(15) NOT NULL PRIMARY KEY,
    org char(15) NOT NULL,
    name char(63) NOT NULL,
    venue char(63) NOT NULL,
    start DATE NOT NULL,
    end DATE NOT NULL,
    contact char(127) NOT NULL,
    entries_until DATE NOT NULL,
    entries_limit integer DEFAULT 0,
    details varchar(512)
);

insert into event set id="Thei5eiZoopoquo",org="ahhie6Xixaule5I",name="Kommandokamp 2017",start="2017-11-24",end="2017-11-26",contact="jan.semmelink@gmail.com",venue="Kwaggasrus",entries_limit=120,details="Busse vertrek Vrydag 24 Nov 15:00 vanaf Midstream College en keer terug op Sondag 26 Nov na middagete.",entries_until="2017-10-31";

# list of event entry types
create table entry_type (
    id char(15) NOT NULL PRIMARY KEY,
    event char(15) NOT NULL,
    org_group char(15) NOT NULL,
    cost integer DEFAULT 0
);

#insert into entry_type set id="",event="Thei5eiZoopoquo",org_group="Oofioj1Eikei4ph",cost=600;
#...
echo "select id from org_group where org_id='ahhie6Xixaule5I';"| mysql -uentryform_web -p'ef$web' entryform -N | while read gid; do echo "gid=${gid}"; echo "insert into entry_type set id='"$(pwgen 15 1)"',event='Thei5eiZoopoquo',org_group='"${gid}"',cost=600;" | mysql -uentryform_web -p'ef$web' entryform -N; done

create table member (
    id char(15) NOT NULL PRIMARY KEY,
    surname char(63) NOT NULL,
    name char(63) NOT NULL,
    account char(31) NOT NULL,
    groupname char(15) NOT NULL,
    gender char(15) NOT NULL
);

create table entry (
    id char(15) NOT NULL,
    event_id char(15) NOT NULL,
    member_id char(15) NOT NULL,
    surname char(63) NOT NULL,
    name char(63) NOT NULL,
    account char(31) NOT NULL,
    groupname char(15) NOT NULL,
    gender char(15) NOT NULL,
    transport char(15) NOT NULL,
    cost integer default 0,
    paid boolean
);

