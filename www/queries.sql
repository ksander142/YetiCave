insert into categories set name='Доски и лыжи'; // делаем запись в таблицу категории с названиями категорий
insert into categories set name='Крепления';
insert into categories set name='Ботинки';
insert into categories set name='Одежда';
insert into categories set name='Инструменты';
insert into categories set name='Разное';

insert into roley set name='registry'; // запись в таблицу ролей с названиями ролей

insert into users set name='testovich', email='test@test.com', password='12345', contacts='славный парень',roley_id='1'; // запись в таблицу пользователей
insert into users set name='crash', email='crash@crash.com', password='54321', contacts='странный парень',roley_id='1';

//запись лотов
insert into lots set name='2014 Rossignol District Snowboard',description='opisanie opisannoe',img='img/lot-1.jpg',start_cost=10999,add_date='2019-10-11',lost_date='2020-01-11',user_id='1',categories_id='1';
insert into lots set name='DC Ply Mens 2016/2017 Snowboard',description='zzzzzzzzzzzzzzzzzzz',img='img/lot-2.jpg',start_cost=15999,lost_date='2019-12-01',user_id='1',categories_id='1';
insert into lots set name='Крепления Union Contact Pro 2015 года размер L/XL',description='123456',img='img/lot-3.jpg',start_cost=8000,lost_date='2019-12-12',user_id='1',categories_id='2';
insert into lots set name='Ботинки для сноуборда DC Mutiny Charocal',description='789999',img='img/lot-4.jpg',start_cost=10999,lost_date='2019-12-23',user_id='1',categories_id='3';
insert into lots set name='Куртка для сноуборда DC Mutiny Charocal',description='xxxxxxxxxxxxxx',img='img/lot-5.jpg',start_cost=7500,lost_date='2019-11-15',user_id='1',categories_id='4';
insert into lots set name='Маска Oakley Canopy',description='ccccccccc',img='img/lot-6.jpg',start_cost=5400,lost_date='2019-11-11',user_id='1',categories_id='6';

//запись ставок
insert into rate set raise_cost=20000,user_id='2',lots_id='1';
insert into rate set raise_cost=9999,user_id='2',lots_id='3';

select * from categories; // чтение всех категорий
select * from lots join categories c on lots.categories_id = c.id where lots.id = 1; // показать лот по его айди + чтоб вышла категория к которой он принадлежит
update lots set name='test' where id=1; // обновить название лота по его id
select l.name,start_cost,img,c.name from lots l join categories c on l.categories_id = c.id ORDER BY l.lost_date DESC  LIMIT 3;// получить самые новые открытые лоты. Каждый лот должен включать название, стартову цену, цену, имг, категорию
select * from rate r join lots l on r.lots_id = l.id ORDER BY l.add_date DESC ; //получить список ставок для лота по его id с сортировкой по дате