#!/bin/bash

#     +----------------------------------------------------------------------+
#     | Gettext migueloo helper script                                       |
#     +----------------------------------------------------------------------+
#     | Copyright (c) 2004, miguel Development Team                          |
#     +----------------------------------------------------------------------+
#     |   This program is free software; you can redistribute it and/or      |
#     |   modify it under the terms of the GNU General Public License        |
#     |   as published by the Free Software Foundation; either version 2     |
#     |   of the License, or (at your option) any later version.             |
#     |                                                                      |
#     |   This program is distributed in the hope that it will be useful,    |
#     |   but WITHOUT ANY WARRANTY; without even the implied warranty of     |
#     |   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the      |
#     |   GNU General Public License for more details.                       |
#     |                                                                      |
#     |   You should have received a copy of the GNU General Public License  |
#     |   along with this program; if not, write to the Free Software        |
#     |   Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA          |
#     |   02111-1307, USA. The GNU GPL license is also available through     |
#     |   the world-wide-web at http://www.gnu.org/copyleft/gpl.html         |
#     +----------------------------------------------------------------------+
#     | Author: Eduardo Robles Elvira <edulix@iespana.es>                    |
#     |          miguel Development Team                                     |
#     |                       <e-learning-desarrollo@listas.hispalinux.es>   |  
#     +----------------------------------------------------------------------+


#################
# Vars:

MIGUEL_DIR="/var/www/html/CVS/migueloo"
# Si hay varios, separar cada idioma con un espacio (' '):
LANGS="es_ES" 

GT_FORMAT="-w 110 -s"
CODE_CHARSET="ISO-8859-15"
GT_KEYWORD="agt"

function add()
{
	if [ "${@}" = "ALL_MODULES" ]
	then
		MODULES=`ls --format=across --color=none`
	else
		MODULES="${@}"
	fi
	
	for _MODULE_ in ${MODULES}
	do
		if [ -d "${MIGUEL_DIR}/modules/${_MODULE_}" ]
		then
			for _LANG_ in ${LANGS}
			do
				FILES=`find ${MIGUEL_DIR}/modules/${_MODULE_}  -name \*.php -printf ' %p'`
				if [ -z "$FILES" ]
				then
					echo "INFO: ${MIGUEL_DIR}/modules/${_MODULE_} no contiene ningún fichero php"
					continue
				fi
				TIME_RND=`date +%N`
				if [ -e ${MIGUEL_DIR}/gettext/${_LANG_}/LC_MESSAGES/${MODULE}.po ]
				then
					xgettext -L PHP --from-code=${CODE_CHARSET} --keyword=${GT_KEYWORD} ${GT_FORMAT} -o ${MIGUEL_DIR}/modules/gettext/${_LANG_}/LC_MESSAGES/${_MODULE_}-${TIME_RND}.po `find ${MIGUEL_DIR}/modules/${_MODULE_}  -name \*.php -printf ' %p'`
					
					if [ "$?" != 0 ]
					then
						echo "!!! Hubo un fallo ejecutando: xgettext -L PHP --from-code=${CODE_CHARSET} --keyword=${GT_KEYWORD} ${GT_FORMAT} -o ${MIGUEL_DIR}/modules/gettext/${_LANG_}/LC_MESSAGES/${_MODULE_}-${TIME_RND}.po `find ${MIGUEL_DIR}/modules/${_MODULE_}  -name \*.php -printf ' %p'`"
						exit 1
					fi
					msgmerge -U ${GT_FORMAT} ${MIGUEL_DIR}/modules/gettext/${_LANG_}/LC_MESSAGES/${_MODULE_}.po ${MIGUEL_DIR}/modules/gettext/${_LANG_}/LC_MESSAGES/${_MODULE_}-${TIME_RND}.po
					if [ "$?" = 0 ]
					then
						echo "INFO: ${_MODULE_} procesado exitosamente"
					else
						echo "!!! Hubo un fallo ejecutando: msgmerge ${GT_FORMAT} ${MIGUEL_DIR}/modules/gettext/${_LANG_}/LC_MESSAGES/${_MODULE_}.po ${MIGUEL_DIR}/modules/gettext/${_LANG_}/LC_MESSAGES/${_MODULE_}-${TIME_RND}.po"
						exit 1
					fi
					rm -f ${MIGUEL_DIR}/gettext/${_LANG_}/LC_MESSAGES/${_MODULE_}-${TIME_RND}.po
				else
					xgettext -L PHP --from-code=${CODE_CHARSET} --keyword=${GT_KEYWORD} ${GT_FORMAT} -o ${MIGUEL_DIR}/modules/gettext/${_LANG_}/LC_MESSAGES/${_MODULE_}.po `find ${MIGUEL_DIR}/modules/${_MODULE_}  -name \*.php -printf ' %p'`
					
					if [ "$?" = 0 ]
					then
						echo "INFO: ${_MODULE_} procesado exitosamente"
					else
						echo "!!! Hubo un fallo ejecutando: xgettext -L PHP --from-code=${CODE_CHARSET} --keyword=${GT_KEYWORD} ${GT_FORMAT} -o ${MIGUEL_DIR}/modules/gettext/${_LANG_}/LC_MESSAGES/${_MODULE_}.po `find ${MIGUEL_DIR}/modules/${_MODULE_}  -name \*.php -printf ' %p'`"
						exit 1
					fi
				fi
			done
		else
			echo "INFO: ${MIGUEL_DIR}/modules/${_MODULE_} no existe o no es un directorio"
		fi
	done
}

function compile()
{

	if [ ${1} = "ALL_MODULES" ]
	then
		MODULES=`ls --format=across --color=none`
	else
		MODULES=$1
	fi
	
	for _MODULE_ in ${MODULES}
	do
		if [ -d "${MIGUEL_DIR}/modules/${_MODULE_}" ]
		then
			for _LANG_ in ${LANGS}
			do
				if [ -e ${MIGUEL_DIR}/modules/gettext/${_LANG_}/LC_MESSAGES/${_MODULE_}.po ]
				then
					msgfmt ${MIGUEL_DIR}/modules/gettext/${_LANG_}/LC_MESSAGES/${_MODULE_}.po
					
					if [ "$?" = 0 ]
					then
						echo "INFO: ${_MODULE_} procesado exitosamente"
					else
						echo "!!! Hubo un fallo ejecutando: msgfmt ${MIGUEL_DIR}/modules/gettext/${_LANG_}/LC_MESSAGES/${_MODULE_}.po"
						exit 1
					fi
				else
					echo "INFO: ${MIGUEL_DIR}/modules/gettext/${_LANG_}/LC_MESSAGES/${_MODULE_}.po no existe y por tanto no puede ser compilado"
				fi
			done
		
		else
			echo "INFO: ${MIGUEL_DIR}/modules/${_MODULE_} no existe o no es un directorio"
		fi
	done
}
# Shifting away the first argument
first="$1" && shift

case "$first" in
add)
	if [ ! ${#} -gt 1 ]
	then
		$0 help
		exit 1
	fi
	add "$@"
	if [ "$?" = 1 ]
	then
		$0 help
	fi
	;;
compile)
	if [ ! ${#} -gt 1 ]
	then
		$0 help
		exit 1
	fi
	compile "$@"
	if [ "$?" = 1 ]
	then
		$0 help
	fi
	;;
*)
	echo "$0 es un pequeño programa que parsea el código de los módulos de migueloo especificados en busca de variables a traducir y crea/actualiza/compila los ficheros de traducción correspondientes.

Uso:
$0 add <miguel_module(s)>+
or
$0 compile <miguel_module(s)>+

 - Sustituya <miguel_module(s)> por el/los módulos que quiera crear/actualizar/compilar
 - El comando 'add' conservará los ficheros de traducción existentes actualizándolos (gracias a msgmerge)
 - Puede usar como argumento ALL_MODULES, sirviendo este como 'todos los módulos de miguel disponibles'
 - Por favor, edite las variables de configuración necesarias editando el código de este fichero
 - Ejecute '$0 help' para volver a mostrar esta información"
	;;
esac
exit 0