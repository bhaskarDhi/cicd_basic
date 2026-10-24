pipeline {
    agent any

    triggers {
        pollSCM('H/2 * * * *')
    }

    environment {
        IMAGE  = 'bdhirubhask/taskapp'
        SERVER = 'ubuntu@13.205.81.47'
    }

    stages {
        stage('Test') {
            steps {
                sh 'docker build --target test -t taskapp-test .'
            }
        }

        stage('Build') {
            steps {
                sh 'docker build --platform linux/amd64 --target production -t $IMAGE:$BUILD_NUMBER -t $IMAGE:latest .'
            }
        }

        stage('Push') {
            steps {
                withCredentials([usernamePassword(credentialsId: 'dockerhub', usernameVariable: 'DH_USER', passwordVariable: 'DH_TOKEN')]) {
                    sh '''
                        echo "$DH_TOKEN" | docker login -u "$DH_USER" --password-stdin
                        docker push $IMAGE:$BUILD_NUMBER
                        docker push $IMAGE:latest
                    '''
                }
            }
        }

        stage('Deploy') {
            steps {
                withCredentials([sshUserPrivateKey(credentialsId: 'ec2-ssh', keyFileVariable: 'SSH_KEY')]) {
                    sh '''
                        ssh -i "$SSH_KEY" -o StrictHostKeyChecking=no $SERVER "
                            cd /opt/taskapp &&
                            docker compose pull app &&
                            docker compose up -d &&
                            docker compose exec -T app php artisan migrate --force
                        "
                    '''
                }
            }
        }
    }

    post {
        always {
            sh 'docker logout || true'
        }
        success {
            echo 'Deployed: http://13.205.81.47'
        }
    }
}
