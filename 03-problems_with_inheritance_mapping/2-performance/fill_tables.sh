#!/bin/sh

DB_NAME="mooc"
NUM_ROWS=10000
BATCH_SIZE=500

declare -a STEPS_MAIN
declare -a STEPS_VIDEO
declare -a STEPS_EXERCISE
declare -a STEPS_QUIZ
declare -a STEPS_INLINE

function join_by {
    local IFS="$1"
    shift
    echo "$*"
}

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

  STEPS_MAIN+=("('$ID', '$TITLE', $DURATION, '$TYPE')")

  case $TYPE in
    "video")
      URL="http://video$i.com"
      STEPS_VIDEO+=("('$ID', '$URL')")
      ;;
    "exercise")
      CONTENT="Contenido $i"
      STEPS_EXERCISE+=("('$ID', '$CONTENT')")
      ;;
    "quiz")
      QUESTIONS="Pregunta $i"
      STEPS_QUIZ+=("('$ID', '$QUESTIONS')")
      ;;
  esac

  STEPS_INLINE+=("('$ID', '$TITLE', $DURATION, '$TYPE', '$URL', '$CONTENT', '$QUESTIONS')")

  if [ $((i % BATCH_SIZE)) -eq 0 ] || [ $i -eq $NUM_ROWS ]; then
    MAIN_VALUES=$(join_by , "${STEPS_MAIN[@]}")
    VIDEO_VALUES=$(join_by , "${STEPS_VIDEO[@]}")
    EXERCISE_VALUES=$(join_by , "${STEPS_EXERCISE[@]}")
    QUIZ_VALUES=$(join_by , "${STEPS_QUIZ[@]}")
    INLINE_VALUES=$(join_by , "${STEPS_INLINE[@]}")

    docker exec -i codely-infra_modeling_inheritance_mapping-performance mariadb $DB_NAME -e "INSERT INTO steps (id, title, duration, type) VALUES $MAIN_VALUES;"
    [ ${#STEPS_VIDEO[@]} -ne 0 ] && docker exec -i codely-infra_modeling_inheritance_mapping-performance mariadb $DB_NAME -e "INSERT INTO steps_video (id, url) VALUES $VIDEO_VALUES;"
    [ ${#STEPS_EXERCISE[@]} -ne 0 ] && docker exec -i codely-infra_modeling_inheritance_mapping-performance mariadb $DB_NAME -e "INSERT INTO steps_exercise (id, content) VALUES $EXERCISE_VALUES;"
    [ ${#STEPS_QUIZ[@]} -ne 0 ] && docker exec -i codely-infra_modeling_inheritance_mapping-performance mariadb $DB_NAME -e "INSERT INTO steps_quiz (id, questions) VALUES $QUIZ_VALUES;"
    docker exec -i codely-infra_modeling_inheritance_mapping-performance mariadb $DB_NAME -e "INSERT INTO steps_inline (id, title, duration, type, url, content, questions) VALUES $INLINE_VALUES;"

    STEPS_MAIN=()
    STEPS_VIDEO=()
    STEPS_EXERCISE=()
    STEPS_QUIZ=()
    STEPS_INLINE=()

    echo "Steps inserted up to $i/$NUM_ROWS"
  fi
done
