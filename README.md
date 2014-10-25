proyecto-ventanilla
===================

Aplicación Web para ventanilla activos en Control Escolar del CUCI.

PROYECTO:
SISTEMA DE SOLICITUDES EN VENTANILLA “ALUMNOS ACTIVOS”.
Se solicita un sistema para llevar el control de las solicitudes que se hacen en el edificio de Control Escolar del Centro Universitario de la Ciénega; más específicamente en la ventanilla “Alumnos activos”.
Se requiere una estructura de base de datos con las siguientes características:
1.	De cada alumno se desea guardar: nombre, apellido paterno, apellido materno, código de estudiante y carrera.
2.	De cada administrador (usuario) del sistema se desea guardar: nombre, apellidos y código de usuario.
3.	Por cada solicitud que se haga guardar: tipo de documento, código de alumno, código de usuario y un status de documento.
El sistema deberá ser capaz de poder hacer peticiones de documentos que los alumnos requieran, esto es, un alumno puede hacer varias solicitudes. 

Descripción
El sistema será usado para recibir las solicitudes de los alumnos. 
Actualmente trabajan sobre un sistema basado en la plataforma Microsoft Office Access de Windows. 
Una de las características del sistema actual es que, al hacer una solicitud de algún documento, el usuario debe firmar de recibido al entregarle la misma. Lo que conlleva a que se tengan que imprimir reportes en papel cada cierto tiempo. 
Esta sería una de las mejoras más importantes al sistema. Nuestro sistema estaría haciendo algo muy parecido a lo que antes se hacía, pero no sería necesario que el usuario tenga que firmar nada y que la dependencia tampoco imprima ningún tipo de reporte.
Otra característica importante es llevar un registro de las personas que han “levantado pedido”; a las personas que traten de acceder al sistema se les tendrá que registrar y proporcionar una contraseña (que después puede cambiar). 
Haciendo con esto un registro de quien haya levantado, firmado y entregado documentos solicitados, desligando responsabilidades.
Y otra de las características más importantes es que cada documento que soliciten salga con una “nota de estado”. Las notas de estado serán activadas por la persona que haga cada una de las siguientes acciones:
•	Recibir en ventanilla alguna solicitud: marcará como “Enviado” el documento.
•	Llevar a firmar los documentos ante las personas competentes: marcará como “Firmado” cada documento.
•	Entregar al alumno el documento que solicitó: marcará como “Entregado” el documento.
Haciendo esto se pretende que se agilice la entrega de documentos, que se haga en menos tiempo y que el administrador no pierda tiempo en buscar el papel solicitado, sin saber si quiera, si está firmado o no.
Con esto también eliminaríamos el hecho de que el alumno firme de entregado en algún papel, el administrador al marcar como “Entregado” el documento le dice al sistema que ya fue despachado ese documento.

