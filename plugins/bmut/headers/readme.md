# Cabeceras y breadcrumbs para October CMS

***
## Cabeceras
`Headers > Headers`

Este plugin sirve para generar cabeceras para las páginas estáticas
Tiene la opción de elegir una página, añadir una imagen un título y un subtítulo.

## Breadcrumbs
`Headers > Breadcrumbs`

Este apartado sirve para crear breadcrumbs en las páginas.
También crea un richsnippet con los datos del breadcrumb para que salga bonito en google.

Seleccionamos una página del listado del tema.
(La primera no puede tener padre).
Le indicamos un título, un tipo y de manera opcional podemos indicar un elemento del DOM, para indicar de donde queremos sacar el título si es una página dinámica.
Por ejemplo, para que el breadcrumb de una página de un post de blog sea "home > blog > titulo del blog".
Tenemos que crear la página home con título home, la página blog con título blog y la página del post, el título de esta nos da un poco igual, porque queremos coger el título del propio post.
Para eso en "Page Element" ponemos un id de un elemento de la página que muestre el título del post.
```
    <span id="blog-title" style="display:none">{{post.title}}</span>
```
En este caso en "Pase Element" pondríamos "blog-title".
Y un javascript que se carga con el componente de breadcrumb se encarga de cambiar el título del breadcrumb por el contenido de ese span.


El **Tipo** es un selector para sobreescribir los eventos por defecto.

Hay dos eventos.
El de generar tipos y el de generar los breadcrumbs.
En las páginas dinámicas con un solo parámetro, está funcionando ya correctamente.

## Sliders
`Headers > Sliders`

Este apartado sirve para asignar Sliders a páginas **estáticas**. Consta de un component que, al incluirlo en el layout mismo, mira en qué página se encuentra y busca en db si hay algún slider asignado.

La relación con las slides es N-M por lo que se pueden pasar slides de un slider a otro, compartirlas, reordenarlas para cada slider en concreto, desactivar una slide se desactiva en todos los sliders, ...

Si se necesitasen más campos en los slides se puede extender el plugin añadiendo campos como second_description, link, iframe o relaciones con otros modelos de nuestra web como Project, Service, ... [Mirar docs como extender plugins]

***
### Consejos

Cambiando los permisos de usuarios (p.e. quitando el acceso a bmut.headers Breadcrumbs) desaparecen las secciones del sidemenu a las que no se tiene acceso.
Salvo para la gestión de Headers (`Headers > Headers`). Que al acceder a través del icono principal de bmut.headers (el del menú horizontal) nos llevará a una página a la que no tenemos permisos para acceder.

Si no se usa en la web, y se quiere ocultar para que el cliente no vea una sección que no se usa en su web, se deberá crear un nuevo menú en el plugin de nuestra web (`plugin.yaml`) como el siguiente:
```
navigation:
    custom-bmut-headers:
            label: 'bmut.headers::lang.menu.headers'
            url: bmut/headers/breadcrumbs
            icon: icon-file-text-o
            permissions:
                - bmut-headers-breadcrumbs
            sideMenu:
                inner-breadcrumbs:
                    label: Breadcrumbs
                    url: bmut/headers/breadcrumbs
                    icon: icon-sitemap
                    permissions:
                        - bmut-headers-breadcrumbs
    ...
```
Y cambiar el contexto a los controladores de los otros apartados que quedan, para que incorporen el nuevo sidemenu y se marque como activo el icono de la página en la que estamos (`Plugin.php`):
```
use BackendMenu;
use Bmut\Headers\Controllers\Breadcrumbs as BreadcrumbsController;

class Plugin extends PluginBase
{
    public function boot()
    {
        // MODIFICAR bmut.headers -> MENU
        Event::listen('backend.menu.extendItems', function($menu) {
            $menu->removeMainMenuItem('bmut.headers', 'main-headers');
        });

        Event::listen('backend.page.beforeDisplay', function ($controller, $action, $params) {
            if ($controller instanceof BreadcrumbsController) {
                BackendMenu::setContext('Autor.Plugin', 'custom-bmut-headers', 'inner-breadcrumbs');
            }
        });
        ...
```
