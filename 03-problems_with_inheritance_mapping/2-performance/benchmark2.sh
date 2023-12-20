joined_query='SELECT
           s.id,
           s.title,
           s.duration,
           s.type,
           CASE
               WHEN s.type = "video" THEN v.url
               WHEN s.type = "exercise" THEN e.content
               WHEN s.type = "quiz" THEN q.questions
           END AS details
       FROM
           steps s
       LEFT JOIN
           steps_video v ON s.id = v.id AND s.type = "video"
       LEFT JOIN
           steps_exercise e ON s.id = e.id AND s.type = "exercise"
       LEFT JOIN
           steps_quiz q ON s.id = q.id AND s.type = "quiz"
       WHERE
           s.id = (SELECT id FROM steps ORDER BY RAND() LIMIT 1);'

single_query='SELECT * FROM steps_inline WHERE id = (SELECT id FROM steps ORDER BY RAND() LIMIT 1);'

hyperfine "docker exec -i codely-infra_modeling_inheritance_mapping-performance mariadb mooc -e '$joined_query'" "docker exec -i codely-infra_modeling_inheritance_mapping-performance mariadb mooc -e '$single_query'" --warmup 1
