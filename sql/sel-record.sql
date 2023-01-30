.header on

--select count(*) from record;

select * from record inner join recoCat on record.recoCatId = recoCat.id limit 5;

--select * from record order by id desc limit 5;
