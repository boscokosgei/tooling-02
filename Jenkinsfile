pipeline {
    agent any

    environment {
        DOCKERHUB_CREDENTIALS = credentials('dockerhub-creds')
        IMAGE_NAME = "boscokipkosgei/tooling-app"
        IMAGE_TAG  = "${env.BUILD_NUMBER}"
        TEST_CONTAINER = "tooling-test-${env.BUILD_NUMBER}"
        TEST_DB = "tooling-test-db-${env.BUILD_NUMBER}"
        TEST_NETWORK = "tooling-test-net-${env.BUILD_NUMBER}"
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Build Docker Image') {
            steps {
                sh "docker build -t ${IMAGE_NAME}:${IMAGE_TAG} -t ${IMAGE_NAME}:latest ."
            }
        }

        stage('Test - Smoke Test') {
            steps {
                script {
                    sh "docker network create ${TEST_NETWORK}"

                    sh """
                        docker run -d --name ${TEST_DB} \
                          --network ${TEST_NETWORK} \
                          -e MYSQL_DATABASE=toolingdb \
                          -e MYSQL_USER=tooling_user \
                          -e MYSQL_PASSWORD=Passw0rd! \
                          -e MYSQL_RANDOM_ROOT_PASSWORD=1 \
                          mysql:8.0
                    """

                    // wait for MySQL to actually accept connections, not just start
                    sh """
                        for i in \$(seq 1 30); do
                          docker exec ${TEST_DB} mysqladmin ping -h localhost -u tooling_user -pPassw0rd! --silent && break
                          echo "Waiting for MySQL... (\$i/30)"
                          sleep 2
                        done
                    """

                    sh """
                        docker run -d --name ${TEST_CONTAINER} \
                          --network ${TEST_NETWORK} \
                          -e DB_HOST=${TEST_DB} \
                          -e DB_USER=tooling_user \
                          -e DB_PASS=Passw0rd! \
                          -e DB_NAME=toolingdb \
                          -p 5050:80 \
                          ${IMAGE_NAME}:${IMAGE_TAG}
                    """

                    sh "sleep 5"

                    sh """
                        STATUS=\$(curl -s -o /dev/null -w "%{http_code}" http://localhost:5050)
                        echo "HTTP status: \$STATUS"
                        if [ "\$STATUS" != "200" ]; then
                          echo "Smoke test failed: expected 200, got \$STATUS"
                          exit 1
                        fi
                    """
                }
            }
        }

        stage('Login to Docker Hub') {
            steps {
                sh 'echo $DOCKERHUB_CREDENTIALS_PSW | docker login -u $DOCKERHUB_CREDENTIALS_USR --password-stdin'
            }
        }

        stage('Push Docker Image') {
            steps {
                sh "docker push ${IMAGE_NAME}:${IMAGE_TAG}"
                sh "docker push ${IMAGE_NAME}:latest"
            }
        }
    }

    post {
        always {
            sh "docker rm -f ${TEST_CONTAINER} || true"
            sh "docker rm -f ${TEST_DB} || true"
            sh "docker network rm ${TEST_NETWORK} || true"
            sh 'docker logout || true'
            sh "docker rmi ${IMAGE_NAME}:${IMAGE_TAG} || true"
            sh "docker rmi ${IMAGE_NAME}:latest || true"
        }
        success {
            echo "Build, test, and push succeeded for ${IMAGE_NAME}:${IMAGE_TAG}"
        }
        failure {
            echo "Pipeline failed — check console output above for the failing stage."
        }
    }
}
