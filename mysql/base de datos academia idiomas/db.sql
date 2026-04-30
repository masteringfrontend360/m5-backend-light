-- DBdiagram --> https://dbdiagram.io/d/Escuela-de-idiomas-69f29678ddb9320fdc9456d3

Table idiomas {
  id bigint [pk, increment]
  nombre varchar(100)
  codigo varchar(10, unique)
  activo boolean [default: true]
  created_at datetime
}

Table profesores {
  id bigint [pk, increment]
  nombre varchar(100)
  apellidos varchar(150)
  email varchar(150, unique)
  telefono varchar(30)
  activo boolean [default: true]
  created_at datetime
}

Table niveles {
  id bigint [pk, increment]
  idioma_id bigint [ref: > idiomas.id]
  nombre varchar(50)
  orden int
  activo boolean [default: true]
  created_at datetime
}

Table clases {
  id bigint [pk, increment]

  idioma_id bigint [ref: > idiomas.id]
  nivel_id bigint [ref: > niveles.id]
  profesor_id bigint [ref: > profesores.id]

  nombre varchar(150)

  dia_semana int
  hora_inicio time
  hora_fin time

  aula varchar(50)
  plazas int

  activo boolean [default: true]
  created_at datetime
}

Table alumnos {
  id bigint [pk, increment]
  nombre varchar(100)
  apellidos varchar(150)
  email varchar(150, unique)
  telefono varchar(30)

  fecha_nacimiento date

  activo boolean [default: true]
  created_at datetime
}

Table matriculas {
  id bigint [pk, increment]

  alumno_id bigint [ref: > alumnos.id]
  clase_id bigint [ref: > clases.id]

  fecha_inscripcion datetime

  estado varchar(20)  // activa, baja, pendiente

  created_at datetime
}

Table evaluaciones {
  id bigint [pk, increment]

  matricula_id bigint [ref: > matriculas.id]

  nota decimal(5,2)
  comentario text

  fecha datetime

  created_at datetime
}

Table pagos {
  id bigint [pk, increment]

  matricula_id bigint [ref: > matriculas.id]

  cantidad decimal(10,2)
  metodo_pago varchar(50)

  estado varchar(20)  // pendiente, pagado, fallido

  fecha_pago datetime

  created_at datetime
}

DiagramView Default {
  Tables {
    idiomas
    profesores
    niveles
    clases
    alumnos
    matriculas
    evaluaciones
    pagos
  }
}
