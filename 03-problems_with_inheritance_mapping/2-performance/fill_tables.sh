#!/bin/sh

DB_NAME="mooc"
NUM_ROWS=1000

for i in $(seq 1 $NUM_ROWS)
do
  ID=$(uuidgen)

  STEP_TYPE=$((i % 3))
  TYPE=""
  case $STEP_TYPE in
    0)
      TYPE="video"
      ;;
    1)
      TYPE="exercise"
      ;;
    2)
      TYPE="quiz"
      ;;
  esac
  URL=""
  CONTENT=""
  QUESTIONS=""

  TITLE="Titulo $i"
  DURATION=$(($RANDOM % 120 + 1))

  docker exec -it codely-infra_modeling_inheritance_mapping-performance mariadb $DB_NAME -e "INSERT INTO steps (id, title, duration, type) VALUES ('$ID', '$TITLE', $DURATION, '$TYPE');"

  case $TYPE in
    "video")
      URL="http://video$i.com"
      docker exec -it codely-infra_modeling_inheritance_mapping-performance mariadb $DB_NAME -e "INSERT INTO steps_video (id, url) VALUES ('$ID', '$URL');"
      ;;
    "exercise")
      CONTENT="Contenido $i"
      docker exec -it codely-infra_modeling_inheritance_mapping-performance mariadb $DB_NAME -e "INSERT INTO steps_exercise (id, content) VALUES ('$ID', '$CONTENT');"
      ;;
    "quiz")
      QUESTIONS="Pregunta $i"
      docker exec -it codely-infra_modeling_inheritance_mapping-performance mariadb $DB_NAME -e "INSERT INTO steps_quiz (id, questions) VALUES ('$ID', '$QUESTIONS');"
      ;;
  esac

  docker exec -it codely-infra_modeling_inheritance_mapping-performance mariadb $DB_NAME -e "INSERT INTO steps_inline (id, title, duration, type, url, content, questions) VALUES ('$ID', '$TITLE', $DURATION, '$TYPE', '$URL', '$CONTENT', '$QUESTIONS');"

  echo "Step $i/$NUM_ROWS inserted"
done
