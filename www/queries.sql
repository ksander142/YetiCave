insert into categories set name='Доски и лыжи'; -- делаем запись в таблицу категории с названиями категорий
insert into categories set name='Крепления';
insert into categories set name='Ботинки';
insert into categories set name='Одежда';
insert into categories set name='Инструменты';
insert into categories set name='Разное';

insert into roley set name='registry'; -- запись в таблицу ролей с названиями ролей

insert into users set name='testovich', email='test@test.com', password='12345', contacts='славный парень',roley_id='1'; -- запись в таблицу пользователей
insert into users set name='crash', email='crash@crash.com', password='54321', contacts='странный парень',roley_id='1';

--запись лотов
insert into lots set name='2014 Rossignol District Snowboard',description='opisanie opisannoe',url='img/lot-1.jpg',cost=10999,add_date='2020-02-11',date='2020-01-11',user_id='1',categories_id='1';
insert into lots set name='DC Ply Mens 2016/2017 Snowboard',description='zzzzzzzzzzzzzzzzzzz',url='img/lot-2.jpg',cost=159990,date='2020-12-01',user_id='1',categories_id='1';
insert into lots set name='Крепления Union Contact Pro 2015 года размер L/XL',description='123456',url='img/lot-3.jpg',cost=8000,date='2019-12-12',user_id='1',categories_id='2';
insert into lots set name='Ботинки для сноуборда DC Mutiny Charocal',description='789999',url='img/lot-4.jpg',cost=10999,date='2020-02-23',user_id='1',categories_id='3';
insert into lots set name='Куртка для сноуборда DC Mutiny Charocal',description='xxxxxxxxxxxxxx',url='img/lot-5.jpg',cost=7500,date='2020-11-15',user_id='1',categories_id='4';
insert into lots set name='Маска Oakley Canopy',description='ccccccccc',url='img/lot-6.jpg',cost=5400,date='2019-11-11',user_id='1',categories_id='6';

--запись ставок
insert into rate set raise_cost=20000,user_id='2',lots_id='1';
insert into rate set raise_cost=9999,user_id='2',lots_id='3';

select * from categories; -- чтение всех категорий
select * from lots join categories c on lots.categories_id = c.id where lots.id = 1; -- показать лот по его айди + чтоб вышла категория к которой он принадлежит
update lots set name='test' where id=1; -- обновить название лота по его id
select l.name,start_cost,img,c.name from lots l join categories c on l.categories_id = c.id ORDER BY l.lost_date DESC  LIMIT 3;-- получить самые новые открытые лоты. Каждый лот должен включать название, стартову цену, цену, имг, категорию
select * from rate r join lots l on r.lots_id = l.id ORDER BY l.add_date DESC ; --получить список ставок для лота по его id с сортировкой по дате

--добавляем индекс полнотекстового поиска в существующию таблицу по полям name, description
create fulltext index lot_ft_search on lots(name,description);

----добавляем в таблицу внешний ключ
alter table rate add FOREIGN KEY (lots_id) REFERENCES lots (id);
--- поиск по полям в таблице
select *, MATCH(name,description) AGAINST('district 2014') as score from lots where MATCH(name,description) AGAINST('district');
--поиск по полям таблицы с присоеденением другой таблицы
select *,lots.name as lName,lots.id as lID, c.name as categories, MATCH(lots.name,description) AGAINST('district 2014') as score from lots join categories c on lots.categories_id = c.id where MATCH(lots.name,description) AGAINST('district');
