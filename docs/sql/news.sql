create database codeigniter20141116;
use codeigniter20141116;
create table news(
id int unsigned not null primary key auto_increment,
title varchar(50) not null default '',
author varchar(30) not null default '',
context text,
add_time int unsigned not null default 0

)engine=myisam charset=utf8;