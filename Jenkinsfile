pipeline {
    agent { label 'agent1' }

    parameters {
        string(description: 'Github repo on mvtthxw account', name: 'GITLAB_REPO_NAME', defaultValue: 'php-app')
        string(description: 'AWS Region', name: 'AWS_REGION', defaultValue: 'eu-west-2')
        string(description: 'ECR Registry', name: 'ECR_REGISTRY', defaultValue: '737473224894.dkr.ecr.eu-west-2.amazonaws.com')
        string(description: 'ECR Repo', name: 'ECR_REPOSITORY', defaultValue: 'mmedyk-cicd-mid')
        string(description: 'Docker image tag', name: 'DOCKER_IMAGE_TAG', defaultValue: 'v1.0.2')
    }

    stages {
        stage('Clone Repo') {
            steps {
                script {
                    // Step 1: clone repo
                    sh 'git clone https://github.com/mvtthxw/${GITLAB_REPO_NAME}.git'
                }
            }
        }
        stage('Build image') {
            steps {
                script {
                    // Step 2: set app directory
                    dir("${GITLAB_REPO_NAME}") {
                        // Step 3: build image
                        dockerImage = docker.build("${ECR_REGISTRY}/${ECR_REPOSITORY}:${DOCKER_IMAGE_TAG}")
                    }
                }
            }
        }
        stage('Test app') {
            steps {
                script {
                    // Step 4: Run app
                    dir('php-app') {
                        // Step 5: start app
                        sh 'docker run --name php-app-server --rm -d -p 8080:80 ${ECR_REGISTRY}/${ECR_REPOSITORY}:${DOCKER_IMAGE_TAG} php -S 0.0.0.0:80'
                    }
                }
                script {
                    // Step 6: wait for start
                    sleep 15
                }
                script {
                    // Step 7: check app
                    def response = sh(script: 'curl -s http://localhost:8080', returnStdout: true).trim()
                    echo "Response from app: ${response}"
                }
            }
        }
        stage("Push Docker image to ECR") {
            steps {
                script {
                    withCredentials([[
                        $class: 'AmazonWebServicesCredentialsBinding',
                        credentialsId: 'ecr',
                        accessKeyVariable: 'AWS_ACCESS_KEY_ID',
                        secretKeyVariable: 'AWS_SECRET_ACCESS_KEY'
                    ]]) {
                        // Log in to the ECR registry
                        sh '''
                        aws ecr get-login-password --region ${AWS_REGION} | docker login --username AWS --password-stdin ${ECR_REGISTRY}
                        '''
                        dockerImage.push("${DOCKER_IMAGE_TAG}")
                    }
                }
            }
        }
    }

    // clean up agant
    post {
        always {
            script {
                // Step 10: stop container
                sh 'docker stop php-app-server || true'
            }
            script {
                // Step 11: remove container
                sh 'docker rm php-app-server || true'
            }
            script {
                // Step 12: remove repo
                sh 'rm -rf php-app'
            }
        }
    }
}
