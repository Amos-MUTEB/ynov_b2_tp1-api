# ynov_b2_tp1-api

# 1. Quel est l'intérêt de créer une API plutôt qu'une application classique ?
dans une situation ou nous avons deux aplication qui tournent à des adresses différentes (le front et le back ), l'intérêt d'une api est permettre  la communication entre ces  deux applications diffirente

# 2. Résumez les étapes du mécanisme de sérialisation implémenté dans Symfony
La sérialisation sert en la transformation d'un Objet en text, 
$ composer req serialization // L'installation 
=> Aller dans le controlleur et importer : 
use Symfony\Component\Serializer\SerializerInterface;
=> Utiliser le composant serialisation selon le besoin dans le code , avant il faut le déclarer dans la classe

# 3. Qu'est-ce qu'un groupe de sérialisation ? A quoi sert-il ?
un groupe de sérialisation utilisé avec cet annotation,  -- @Groups("car:create") -- est utilisé pour spécifier les champs qu'on ne désire pas exposé au client. Le format de serialization utilisé est du json ; cela nécessite d'avoir un composant de serialization

# 4. Quelle est la différence entre la méthode PUT et la méthode PATCH ?

PUT modification complète d'un objet 
PUTCH : modification partiel

# 5. Quels sont les différents types de relation entre entités pouvant être mis en place avec Doctrine ?
- RELATION MANY TO ONE
- RELATION MANY TO MANY
- RELATION ONE TO ONE

# 6. Qu'est-ce qu'un Trait en PHP et à quoi peut-il servir ?
assez minime mais très utiles dans certains cas, Un trait sert à l'import d'un code dans une classe en vue de la factorisation