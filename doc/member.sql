create table member(
id int(10) not null primary key auto_increment,
login_name varchar(50) not null,
name varchar(50),
passwordvarchar(32) NOT NULL,
create_time int(10) not null,
self_desc varchar(200),
email varchar(50),
mobile varchar(11),
sex enum('male','famale'),
face_pic varchar(50)
)DEFAULT CHARSET=utf8;  
