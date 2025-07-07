create view employe_departement as
select
e.emp_no,
e.birth_date,
e.first_name,
e.last_name,
e.gender,
e.hire_date,
d.dept_no,
d.dept_name
from employees e 
join dept_emp de 
on e.emp_no= de.emp_no
join departments d
on de.dept_no=d.dept_no;

select count(*),d.dept_no
from employees e 
join dept_emp de 
on e.emp_no= de.emp_no
join departments d
on de.dept_no=d.dept_no
group by d.dept_no;
