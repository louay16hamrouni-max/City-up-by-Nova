# Diagramme de classes - module Avis

```mermaid
classDiagram
  class ReviewController {
    +index()
    +save()
    +remove()
    +admin()
    +moderate()
    +addTarget()
  }
  class Review {
    +targets()
    +all(approvedOnly)
    +one(id)
    +average(targetId)
    +add(input, owner)
    +update(id, input, owner)
    +delete(id, owner, moderator)
    +moderate(id, status)
    +addTarget(name, type)
  }
  class Target {
    +id: int
    +name: string
    +type: string
  }
  class ReviewEntry {
    +id: int
    +targetId: int
    +author: string
    +rating: int
    +comment: string
    +status: string
  }
  ReviewController --> Review
  Review "1" o-- "*" ReviewEntry
  Target "1" <-- "*" ReviewEntry : targetId
```

Dans ce prototype JSON, la relation `ReviewEntry.targetId -> Target.id` permet d'afficher le commerce/événement/lieu de chaque avis. Cela n'est pas une jointure SQL ; dans la version BDD, utiliser une clé étrangère et un JOIN.
