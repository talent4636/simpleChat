/*db_name: message*/
create table message_main(
msg_id int(10) not null primary key auto_increment,
send_from int(10) not null,
send_to int(10) not null,
content varchar(500),
time int(10) not null,
status enum('1','2') not null default '1'
)DEFAULT CHARSET=utf8;  
